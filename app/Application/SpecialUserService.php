<?php

namespace App\Application;

use App\Application\Exceptions\UserNotFoundException;
use App\Application\UserDataSource\UserDataSource;

class SpecialUserService
{
    private UserDataSource $userDataSource;

    public function __construct(UserDataSource $userDataSource)
    {
        $this->userDataSource = $userDataSource;
    }

    public function execute(): array
    {
        $userList = $this->userDataSource->getAll();
        $specialUserList = [];
        foreach($userList as $user){
            if($this->isSpecialUser($user->getId())){
                array_push($specialUserList, $user);
            }
        }
        return $specialUserList;
    }

    private function isSpecialUser($id): bool
    {
        return $id % 2 == 0 or $id % 5 == 0;
    }
}
