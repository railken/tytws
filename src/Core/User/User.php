<?php

namespace Core\User;

use Illuminate\Foundation\Auth\User as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Railken\Laravel\Manager\ModelContract;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Railken\Laravel\Manager\Permission\UserContract;

class User extends Model implements ModelContract, UserContract
{
	
    use Notifiable;
	use HasApiTokens;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
        'username', 'email', 'password', 'avatar'
	];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function getIdentifier()
    {
        return $this->id;
    }

}