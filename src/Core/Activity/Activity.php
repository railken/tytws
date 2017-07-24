<?php

namespace Core\Activity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Railken\Laravel\Manager\ModelContract;
use Railken\Laravel\Manager\Permission\ResourceContract;
use Core\Team\Team;
use Core\User\User;

class Activity extends Model implements ModelContract, ResourceContract
{
	
	use SoftDeletes;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'activities';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['description', 'started_at', 'ended_at', 'user_id', 'team_id'];

	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'started_at', 'ended_at'];

    /**
     * User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Team
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    
    public function getUser()
    {
    	return $this->user;
    }

    public function getTimeSpent()
    {
        return $this->ended_at->getTimestamp() - $this->started_at->getTimestamp();
    }
}