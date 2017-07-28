<?php

namespace Core\Activity;

use Railken\Laravel\Manager\ModelSerializer;
use Railken\Laravel\Manager\ModelContract;

class ActivitySerializer extends ModelSerializer
{
    /**
     * Construct
     *
     * @param ActivityManager $manager
     */
    public function __construct(ActivityManager $manager)
    {
        $this->manager = $manager;
    }

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
			'breaks' => $entity->breaks,
			'team' => [
				'id' => $entity->team_id
			]
		];
	}


	/**
	 * Serliaze info team
	 *
	 * @param ModelContract $entity
	 *
	 * @return array
	 */
	public function info($activities, $activities_from, $activities_to)
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

	/**
	 * Serliaze reports team
	 *
	 * @param ModelContract $entity
	 *
	 * @return array
	 */
	public function reports($activities, $activities_from, $activities_to)
	{

		if (empty($activities))
			return [];

		return [
			'hoursPerDay' => $this->reportHoursPerDay($activities, $activities_from, $activities_to)
		];
	}

	public function reportHoursPerDay($activities, $activities_from, $activities_to)
	{
		$data = collect();

		for ($date = clone $activities_from; $date <= (clone $activities_to)->setTime(23, 59, 59); $date->modify("+1 days")) {
			$data[$date->format('Y-m-d')] = 0;
		}


		$activities->map(function($activity) use (&$data){
            
            $index = $activity->started_at->format('Y-m-d');

            if (!isset($data[$index]))
            	$data[$index] = 0;

			$data[$index] += $activity->getTimeSpent();

        });

		$data = $data->map(function($v) {
        	return $v/3600;
		})->sortBy(function($k, $key) {
			return (new \DateTime($key))->getTimestamp();
		});

        return [
        	'labels' => array_keys($data->toArray()),
        	'data' => array_values($data->toArray())
        ];

	}
}
