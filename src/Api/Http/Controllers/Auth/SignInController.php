<?php

namespace Api\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Api\Http\Controllers\Controller;
use Core\User\UserManager;
use Core\User\UserSerializer;
use Api\Api\Manager as ApiManager;
use Api\OAuth\Entity\AccessToken;
use Api\OAuth\GithubProvider;
use Api\OAuth\GitlabProvider;

class SignInController extends Controller
{


    /**
     * List of all providers
     *
     * @var array
     */
    protected $providers = [
        'github' => GithubProvider::class,
        'gitlab' => GitlabProvider::class,
    ];

    /**
     * Get provider
     *
     * @return Provider
     */
    public function getProvider($name)
    {
        $class = isset($this->providers[$name]) ? $this->providers[$name] : null;

        if (!$class) {
            return null;
        }

        return new $class;
    }
    /**
     * Construct
     *
     * @param UserSerializer $user
     */
    public function __construct(UserManager $manager, UserSerializer $serializer)
    {
        $this->serializer = $serializer;
        $this->manager = $manager;
    }

    /**
     * Request token and generate a new one
     *
     * @param string $provider
     * @param Request $request
     *
     * @return Response
     */
    public function accessToken($provider, Request $request)
    {
        $provider = $this->getProvider($provider);

        if (!$provider) {
            return $this->error(['message' => 'No provider found']);
        }

        try {

            $response = $provider->getAccessToken($request);
            $access_token = $response->access_token;

        } catch (\Exception $e) {
            return $this->error([
                'message' => 'Code invalid or expired'
            ]);
        } 

        return $this->success(['data' => [
            'resource' => [
                'access_token' => $access_token
            ]
        ]]);

    }


    /**
     * Request token and generate a new one
     *
     * @param string $provider
     * @param Request $request
     *
     * @return Response
     */
    public function exchangeToken($provider, Request $request)
    {
        $provider = $this->getProvider($provider);

        if (!$provider) {
            return $this->error(['message' => 'No provider found']);
        }

        $access_token = $request->input('access_token');

        if (!$access_token) {
            return $this->error([
                "message" => "access_token is missing"
            ]);
        }

        try {
            $provider_user = $provider->getUser($access_token);
        } catch (\Exception $e) {
            return $this->error([
                'message' => 'Token invalid or expired'
            ]);
        } 
        $user = $this->manager->getRepository()->findByEmail($provider_user->email);

        if (!$user) {
            $user = $this->manager->create([
                'username' => $provider_user->username,
                'role' => 'user',
                'password' => null,
                'avatar' => $provider_user->avatar,
                'email' => $provider_user->email
            ]);
        }

        $token = $this->issueAccessToken($user);

        return $this->success(['data' => [
            'resource' => $this->serializer->token($token)
        ]]);
    }


    /**
     * Issue access token
     *
     * @param User $user
     *
     * @return Response
     */
    public function issueAccessToken($user)
    {
        $maxGenerationAttempts = \League\OAuth2\Server\Grant\AbstractGrant::MAX_RANDOM_TOKEN_GENERATION_ATTEMPTS;

        $client = (new \Laravel\Passport\ClientRepository())->find(2);
        $scopes = [];

        $accessToken = new AccessToken();
        $accessToken->client()->associate($client);
        $accessToken->user()->associate($user);
        $accessToken->scopes=[];
        $accessToken->revoked = 0;
        $accessToken->expires_at = ((new \DateTime())->add(\Laravel\Passport\Passport::tokensExpireIn()));


        while ($maxGenerationAttempts-- > 0) {
            $accessToken->id = bin2hex(random_bytes(40));
            try {
                $accessToken->save();

                return $accessToken;
            } catch (\Exception $e) {
                if ($maxGenerationAttempts === 0) {
                    throw $e;
                }
            }
        }
        return $accessToken;
    }
}
