<?php

namespace Api\OAuth;

class GitlabProvider extends Provider
{

    /**
     * Name
     *
     * @var string
     */
    protected $name = 'gitlab';

    /**
     * URL
     *
     * @var string
     */
    protected $url = 'https://gitlab.com/oauth';

    /**
     * Construct
     *
     */
    public function __construct()
    {

    }

    /**
     * Issue access token
     *
     * @return array
     */
    public function getAccessToken($request)
    {
        $client = new \GuzzleHttp\Client();

        try {
            $params =  [
                'form_params' => [
                    'client_id' => $request->input('client_id'),
                    'client_secret' => $request->input('client_secret'),
                    'code' => $request->input('code'),
                    'grant_type' => 'authorization_code',
                    'redirect_uri' => $request->input('redirect_uri'),
                ],
                'headers' => [
                    'Accept' => 'application/json'
                ]
            ];


            $response = $client->request('POST', $this->url."/token", $params);
        } catch (\Exception $e) {
            throw $e;
        }

        $body = json_decode($response->getBody());

        return $body;
    }
    /**
     * Retrieve User
     *
     * @return array
     */
    public function getUser($token)
    {
        $client = new \GuzzleHttp\Client();
        $user = new \stdClass;

        try {
            $response = $client->request('GET', "https://gitlab.com/api/v4/user", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => "Bearer {$token}"
                ],
                'http_errors' => false
            ]);

            $body = json_decode($response->getBody());
        } catch (\Exception $e) {
            throw new \Exception($e);
        }


        $user->username = $body->name;
        $user->avatar = $body->avatar_url;
        $user->email = $body->email;

        return $user;
    }
}
