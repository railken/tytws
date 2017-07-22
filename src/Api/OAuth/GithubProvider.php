<?php

namespace Api\OAuth;

class GithubProvider extends Provider
{

    /**
     * Name
     *
     * @var string
     */
    protected $name = 'github';

    /**
     * URL
     *
     * @var string
     */
    protected $url = 'https://github.com/login/oauth';

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
            $response = $client->request('GET', "https://api.github.com/user", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => "token {$token}"
                ],
                'http_errors' => true
            ]);

            $body = json_decode($response->getBody());
        } catch (\Exception $e) {
            throw new \Exception($e);
        }

        $user->username = $body->name;
        $user->avatar = $body->avatar_url;


        try {
            $response = $client->request('GET', "https://api.github.com/user/emails", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => "token {$token}"
                ],
                'http_errors' => false
            ]);
            $body = json_decode($response->getBody());
        } catch (\Exception $e) {
            return $this->error([]);
        }

        $user->email = $body[0]->email;

        return $user;
    }
}
