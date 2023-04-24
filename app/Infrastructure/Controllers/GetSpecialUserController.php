<?php

namespace App\Infrastructure\Controllers;

use App\Application\SpecialUserService;
use App\Application\UserDataSource\UserDataSource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class GetSpecialUserController extends BaseController
{
    private UserListResponseMapper $userListResponseMapper;
    private SpecialUserService $specialUserService;

    public function __construct(SpecialUserService $specialUserService, UserListResponseMapper $userListResponseMapper)
    {
        $this->specialUserService = $specialUserService;
        $this->userListResponseMapper = $userListResponseMapper;
    }

    public function __invoke(): JsonResponse
    {
        $userList = $this->specialUserService->execute();

        return response()->json($this->userListResponseMapper->map($userList));
    }
}
