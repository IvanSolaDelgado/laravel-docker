<?php

namespace App\Application;

use App\Application\UserDataSource\UserDataSource;

class GlobalProviderMailService
{
    private UserDataSource $userDataSource;
    private array $globalProviders = [
        'providerOne' => 'gmail.com',
        'providerTwo' => 'hotmail.com',
    ];

    public function __construct(UserDataSource $userDataSource)
    {
        $this->userDataSource = $userDataSource;
    }

    public function execute(): array
    {
        $userList = [];
        $users = $this->userDataSource->getAll();

        foreach ($users as $user) {
            if ($this->isGlobalProviderMail($user->getEmail())) {
                array_push($userList, $user);
            }
        }
        return $userList;
    }

    private function isGlobalProviderMail($email): bool
    {
        $splitEmail = explode('@', $email);
        $userDomainMail = $splitEmail[1];
        return in_array($userDomainMail,$this->globalProviders);
    }
}
