<?php

namespace Ushahidi\App\Passport;

use Laravel\Passport\Bridge\User;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use Ushahidi\Factory\UsecaseFactory;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @var UsecaseFactory
     */
    protected $usecaseFactory;

    /**
     * Create a new repository instance.
     *
     * @param  UsecaseFactory  $usecaseFactory
     * @return void
     */
    public function __construct(UsecaseFactory $usecaseFactory)
    {
        $this->usecaseFactory = $usecaseFactory;
    }

    /**
     * @inheritdoc
     */
    public function getUserEntityByUserCredentials(
        $username,
        $password,
        $grantType,
        ClientEntityInterface $clientEntity
    ) {
        $usecase = $this->usecaseFactory->get('users', 'login')
            ->setIdentifiers([
                'email' => $username,
                'password' => $password,
            ]);

        try {
            $data = $usecase->interact();

            return new User($data['id']);
        } catch (\Exception $e) {
            return false;
        }
    }
}
