<?php

namespace App\Application;

use App\Application\Exceptions\UserNotFoundException;
use App\Application\UserDataSource\UserDataSource;

class IsEarlyAdopterService
{
    private UserDataSource $userDataSource;

    public function __construct(UserDataSource $userDataSource)
    {
        $this->userDataSource = $userDataSource;
    }

    public function execute(string $email): bool
    {
        $user = $this->userDataSource->findByEmail($email);
        if (is_null($user)) {
            throw new UserNotFoundException();
        }

        return $user->getId() < 1000;
    }
}
