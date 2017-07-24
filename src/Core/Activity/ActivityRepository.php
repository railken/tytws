<?php

namespace Core\Activity;

use Railken\Laravel\Manager\ModelRepository;

class ActivityRepository extends ModelRepository
{

	/**
	 * Class name entity
	 *
	 * @var string
	 */
	public $entity = Activity::class;

}
