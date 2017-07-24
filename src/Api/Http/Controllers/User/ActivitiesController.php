<?php

namespace Api\Http\Controllers\User;

use Api\Http\Controllers\RestController as Controller;
use Railken\Laravel\Manager\ModelContract;
use Core\Activity\ActivityManager;

class ActivitiesController extends Controller
{

    /**
     * Construct
     *
     * @param TeamManager $manager
     */
    public function __construct(ActivityManager $manager)
    {

        $this->manager = $manager;
    }
}
