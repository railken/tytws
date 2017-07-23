<?php

namespace Core\User;

use Railken\Laravel\Manager\ModelSerializer;
use Railken\Laravel\Manager\ModelContract;
use League\OAuth2\Server\CryptKey;

class UserSerializer extends ModelSerializer
{

	/**
	 * Serialize entity
	 *
	 * @param ModelContract $entity
	 *
	 * @return array
	 */
	public function serialize(ModelContract $entity)
	{
		return [
			'id' => $entity->id,
			'username' => $entity->username,
			'email' => $entity->email,
			'avatar' => $entity->avatar
		];
	}


    public function token($token)
    {
        return [
            'access_token' => (string)$token->convertToJWT(new CryptKey('file://'.\Laravel\Passport\Passport::keyPath('oauth-private.key'))),
            'token_type' => 'bearer',
            'expire_in' => $token->expires_at->getTimestamp() - time()
        ];
    }

}
