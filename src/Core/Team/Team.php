<?php

namespace Core\Team;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Railken\Laravel\Manager\ModelContract;
use Railken\Laravel\Manager\Permission\ResourceContract;
use Core\User\User;

class Team extends Model implements ModelContract, ResourceContract
{
	
	use SoftDeletes;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'teams';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['uid', 'name', 'avatar', 'description', 'user_id'];

	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function getUser()
    {
    	return $this->user;
    }
}