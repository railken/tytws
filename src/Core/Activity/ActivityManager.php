<?php

namespace Core\Activity;

use Railken\Laravel\Manager\ModelContract;
use Railken\Laravel\Manager\ModelManager;
use Railken\Laravel\Manager\Permission\AgentContract;

use Core\Activity\Activity;
use Core\Team\TeamManager;
use Core\User\UserManager;

class ActivityManager extends ModelManager
{

	/**
	 * Construct
	 */
	public function __construct(AgentContract $agent = null)
	{
		$this->repository = new ActivityRepository($this);
		$this->serializer = new ActivitySerializer($this);

		parent::__construct($agent);
	}

	/**
	 * Fill the entity
	 *
	 * @param ModelContract $entity
	 * @param array $params
	 *
	 * @return ModelContract
	 */
	public function fill(ModelContract $entity, array $params)
	{

		$params = $this->getOnlyParams($params, ['user', 'team', 'user_id', 'team_id', 'description', 'started_at', 'ended_at']);


        if (isset($params['user']) || isset($params['user_id'])) {
            $this->vars['user'] = $this->fillManyToOneById($entity, new UserManager(), $params, 'user');
        }

        if (isset($params['team']) || isset($params['team_id'])) {
            $this->vars['team'] = $this->fillManyToOneById($entity, new TeamManager(), $params, 'team');
        }

		$entity->fill($params);

		return $entity;

	}

	/**
	 * This will prevent from saving entity with null value
	 *
	 * @param ModelContract $entity
	 *
	 * @return ModelContract
	 */
	public function save(ModelContract $entity)
	{	

        $entity->user()->associate($this->vars->get('user', $entity->user));
        $entity->team()->associate($this->vars->get('team', $entity->team));

		/*$this->throwExceptionParamsNull([
			'name' => $entity->name,
		]);*/
        $this->throwExceptionAccessDenied('activity.save', $entity);

		return parent::save($entity);
	}


}
