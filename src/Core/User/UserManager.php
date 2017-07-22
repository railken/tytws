<?php

namespace Core\User;

use Railken\Laravel\Manager\ModelContract;
use Railken\Laravel\Manager\ModelManager;
use Railken\Laravel\Manager\Permission\AgentContract;

use Core\User\User;

class UserManager extends ModelManager
{

	/**
	 * Construct
	 */
	public function __construct(AgentContract $agent = null)
	{
		$this->repository = new UserRepository($this);
		$this->serializer = new UserSerializer($this);

		parent::__construct($agent);
	}

    /**
     * Throw an exception if email already exists
     *
     * @param string $email
     *
     * @return void
     */
    public function throwExceptionEmailAlreadyUsed(ModelContract $entity, $email)
    {
        if ($this->getRepository()->uniqueByEmail($entity, $email)) {
            throw new EmailAlreadyUsedException();
        }
    }

   

    /**
     * Throw an exception if email is invalid
     *
     * @param string $email
     *
     * @return void
     */
    public function throwExceptionEmailInvalid($email)
    {
        //throw new EmailInvalidException();
    }

    /**
     * Throw an exception if password is weak
     *
     * @param string $password
     *
     * @return void
     */
    public function throwExceptionPasswordTooWeak($password)
    {
        if (strlen($password) < 3) {
            throw new PasswordTooWeakException();
        }
    }


    /**
     * Fill the entity
     *
     * @param ModelContract $entity
     * @param array $params
     *
     * @return ModelContract
     */
    public function fill(ModelContract $user, array $params)
    {
        $params = $this->getOnlyParams($params, ['username', 'email', 'password', 'avatar']);

        if (isset($params['email'])) {
            $this->throwExceptionEmailAlreadyUsed($user, $params['email']);
            $this->throwExceptionEmailInvalid($params['email']);
        }

        if (isset($params['password'])) {
            $this->throwExceptionPasswordTooWeak($params['password']);
            $params['password'] = bcrypt($params['password']);
        }

        $user->fill($params);


        return $user;
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
        $this->throwExceptionParamsNull([
            'email' => $entity->email,
        ]);

        return parent::save($entity);
    }

}
