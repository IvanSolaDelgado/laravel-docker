<?php

namespace App\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use App\Application\GlobalProviderMailService;

class GetGlobalProviderUsersController extends BaseController
{
    private GlobalProviderMailService $globalProviderMailService;
    private UserListResponseMapper $userListResponseMapper;

    public function __construct(GlobalProviderMailService $globalProviderMailService, UserListResponseMapper $userListResponseMapper)
    {
        $this->globalProviderMailService = $globalProviderMailService;
        $this->userListResponseMapper = $userListResponseMapper;
    }
    public function __invoke(): JsonResponse
    {
        $userList = $this->globalProviderMailService->execute();

        return response()->json($this->userListResponseMapper->map($userList));
    }
}
