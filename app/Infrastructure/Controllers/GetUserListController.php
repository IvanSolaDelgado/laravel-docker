<?php

namespace App\Infrastructure\Controllers;

use App\Application\UserDataSource\UserDataSource;
use App\Domain\User;
use App\Infrastructure\Persistence\FileUserDataSource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use function PHPUnit\Framework\isEmpty;

class GetUserListController extends BaseController
{

    private UserDataSource $userDataSource;

    /**
     * @param UserDataSource $userDataSource
     */
    public function __construct(UserDataSource $userDataSource)
    {
        $this->userDataSource = $userDataSource;
    }

    public function __invoke(): JsonResponse
    {
        $userList = $this->userDataSource->getAll();
        if($userList == null){
            return response()->json([
            ], Response::HTTP_OK);
        }
        return response()->json([
            'id1' => $userList[0]->getId(),
            'email1' => $userList[0]->getEmail(),
            'id2' => $userList[1]->getId(),
            'email2' => $userList[1]->getEmail(),
        ], Response::HTTP_OK);

    }
}
