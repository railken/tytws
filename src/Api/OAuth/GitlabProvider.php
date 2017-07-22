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
