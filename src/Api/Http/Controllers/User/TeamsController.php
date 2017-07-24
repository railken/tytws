<?php

namespace Api\Http\Controllers\User;

use Api\Http\Controllers\RestController as Controller;
use Railken\Laravel\Manager\ModelContract;
use Core\Team\TeamManager;
use Illuminate\Http\Request;

class TeamsController extends Controller
{

    /**
     * Construct
     *
     * @param TeamManager $manager
     */
    public function __construct(TeamManager $manager)
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
    public function show($id, Request $request)
    {
        $this->initialize($request);
        $manager = $this->getManager();

        $entity = $manager->find($id);

       	$activities = $entity
       		->activities()
       		->where("started_at", ">=", $request->input("activities_from", (new \DateTime())->format('Y-m-d 00:00:00')))
       		->where("ended_at", "<=", $request->input("activities_to", (new \DateTime())->format('Y-m-d 23:59:59')))
       		->get();


        if (empty($entity)) {
            abort(404);
        }

        return $this->success([
            'message' => 'ok',
            'data' => [
                'resources' => $this->manager->serializer->serialize($entity, $activities)
            ]
        ]);
    }
}
