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
	public function serialize(ModelContract $entity, $activities = [])
	{
		return [
			'id' => $entity->id,
			'uid' => $entity->uid,
			'name' => $entity->name,
			'description' => $entity->description,
            'avatar' => $entity->avatar ? \Storage::url($entity->avatar)."?=".\Storage::lastModified($entity->avatar) : null,
            'info' => $this->info($entity, $activities)
		];
	}

	/**
	 * Serliaze info team
	 *
	 * @param ModelContract $entity
	 *
	 * @return array
	 */
	public function info(ModelContract $entity, $activities)
	{

		if (empty($activities))
			return [];
		
		return [
			'hours' => $this->infoHours($activities)
		];
	}

	public function infoHours($activities)
	{
		$time = 0;

		$activities->map(function($activity) use (&$time){
            $time += $activity->getTimeSpent();
        });

        return round($time/3600);

	}

}
