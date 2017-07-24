<?php

namespace Api\Http\Controllers\User;

use Api\Http\Controllers\RestController as Controller;
use Railken\Laravel\Manager\ModelContract;
use Core\Activity\ActivityManager;
use Illuminate\Http\Request;
use Api\Helper\Paginator;


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

    /**
     * Return a json response of view list
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $this->initialize($request);
        $manager = $this->getManager();

        $query = $manager->getRepository()->getQuery();

        $searches = $request->input('search', []);

        
        $query->where(function ($qb) use ($searches) {
            foreach ($searches as $name => $search) {
                $qb->where($name, $search);
            }
        });

        $query->where('user_id', $this->getUser()->id);
       		
       	$query->where("started_at", ">=", $request->input("activities_from", (new \DateTime())->format('Y-m-d 00:00:00')));
      	$query->where("ended_at", "<=", $request->input("activities_to", (new \DateTime())->format('Y-m-d 23:59:59')));

        $paginator = Paginator::retrieve($query, $request->input('page', 1), $request->input('show', 10));

        $sort = [
            'field' => strtolower($request->input('sort_field', 'id')),
            'direction' => strtolower($request->input('sort_direction', 'desc')),
        ];

        $results = $query
            ->orderBy($sort['field'], $sort['direction'])
            ->skip($paginator->getFirstResult())
            ->take($paginator->getMaxResults())
            ->get();


        foreach ($results as $n => $k) {
            $results[$n] = $this->serialize($k);
        }

        return $this->success([
            'message' => 'ok',
            'data' => [
                'resources' => $results,
                'pagination' => $paginator,
                'sort' => $sort,
                'search' => $searches,
            ]
        ]);
    }
}
