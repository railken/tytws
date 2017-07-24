<?php

namespace Core\Activity;

use Railken\Laravel\Manager\ModelSerializer;
use Railken\Laravel\Manager\ModelContract;

class ActivitySerializer extends ModelSerializer
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
			'description' => $entity->description,
			'started_at' => $entity->started_at->format('Y-m-d H:i:s'),
			'ended_at' => $entity->ended_at->format('Y-m-d H:i:s'),
			'team' => [
				'id' => $entity->team_id
			]
		];
	}

}
