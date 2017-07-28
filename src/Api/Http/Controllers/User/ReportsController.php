<?php

namespace Api\Http\Controllers\User;

use Api\Http\Controllers\Controller as Controller;
use Railken\Laravel\Manager\ModelContract;
use Core\Activity\ActivityManager;
use Illuminate\Http\Request;

class ReportsController extends Controller
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

    /**
     * Return a json response to get
     *
     * @param Request $request
     *
     * @return Response
    */
    public function activities(Request $request)
    {
        $this->initialize($request);
        $manager = $this->manager;


        $activities_from = new \DateTime($request->input("activities_from", (new \DateTime())->format('Y-m-d H:i:s')));
        $activities_to = new \DateTime($request->input("activities_to", (new \DateTime())->format('Y-m-d H:i:s')));


       	$activities = $this->manager->getRepository()->getQuery()
       		->where("started_at", ">=", $activities_from->format('Y-m-d 00:00:00'))
       		->where("ended_at", "<=", $activities_to->format('Y-m-d 23:59:59'))
       		->get();


        return $this->success([
            'message' => 'ok',
            'data' => [
                'resources' => [
                    'info' => $this->manager->serializer->info($activities, $activities_from, $activities_to),
                    'reports' => $this->manager->serializer->reports($activities, $activities_from, $activities_to),
                ]
            ]
        ]);
    }
}
