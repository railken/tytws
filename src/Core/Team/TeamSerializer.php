<?php

namespace Core\Team;

use Railken\Laravel\Manager\ModelSerializer;
use Railken\Laravel\Manager\ModelContract;

class TeamSerializer extends ModelSerializer
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
			'uid' => $entity->uid,
			'name' => $entity->name,
			'description' => $entity->description,
            'avatar' => $entity->avatar ? \Storage::url($entity->avatar)."?=".\Storage::lastModified($entity->avatar) : null,
            'info' => $this->info($entity)
		];
	}

	/**
	 * Serliaze info team
	 *
	 * @param ModelContract $entity
	 *
	 * @return array
	 */
	public function info(ModelContract $entity)
	{
		return [
			'hours' => $entity->getTotalActivitiesTimeHours(),
		];
	}

}
