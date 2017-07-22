<?php

namespace Core\User;

use Illuminate\Foundation\Auth\User as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Railken\Laravel\Manager\ModelContract;
use Illuminate\Notifications\Notifiable;

class User extends Model implements ModelContract
{
	
    use Notifiable;
	use SoftDeletes;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'user';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
        'username', 'email', 'password',
	];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}