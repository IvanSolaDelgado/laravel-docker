<?php

namespace App\Infrastructure\Controllers;

class SpecialUserListResponseMapper
{
    /**
     * @return UserResponse[]
     */
    public function map(?array $users): array
    {
        $userListResponse = [];
        if (is_null($users)) {
            return $userListResponse;
        }

        foreach ($users as $user) {
            if ($user->getId() % 2 === 0 or $user->getId() % 5 === 0) {
                $userListResponse[] = new UserResponse($user);
            }
        }

        return $userListResponse;
    }
}
