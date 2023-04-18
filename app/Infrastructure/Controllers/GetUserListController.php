<?php

namespace App\Infrastructure\Controllers;

use App\Application\UserDataSource\UserDataSource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class GetUserListController extends BaseController
{
    private UserDataSource $userDataSource;
    private UserListResponseMapper $userListResponseMapper;

    public function __construct(UserDataSource $userDataSource, UserListResponseMapper $userListResponseMapper)
    {
        $this->userDataSource = $userDataSource;
        $this->userListResponseMapper = $userListResponseMapper;
    }

    public function __invoke(): JsonResponse
    {
        $userList = $this->userDataSource->getAll();

        return response()->json($this->userListResponseMapper->map($userList));
    }
}
