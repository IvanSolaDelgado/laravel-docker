<?php

namespace App\Infrastructure\Controllers;

use App\Application\UserDataSource\UserDataSource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class GetSpecialUserController extends BaseController
{
    private UserDataSource $userDataSource;
    private SpecialUserListResponseMapper $specialUserListResponseMapper;

    public function __construct(UserDataSource $userDataSource, SpecialUserListResponseMapper $specialUserListResponseMapper)
    {
        $this->userDataSource = $userDataSource;
        $this->specialUserListResponseMapper = $specialUserListResponseMapper;
    }

    public function __invoke(): JsonResponse
    {
        $userList = $this->userDataSource->getAll();

        return response()->json($this->specialUserListResponseMapper->map($userList));
    }
}
