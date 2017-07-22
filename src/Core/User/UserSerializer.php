<?php

namespace Core\User;

use Railken\Laravel\Manager\ModelSerializer;
use Railken\Laravel\Manager\ModelContract;

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
			'id' => $entity->id
		];
	}

}
