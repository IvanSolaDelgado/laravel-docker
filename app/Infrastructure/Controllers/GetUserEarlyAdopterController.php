<?php

namespace App\Infrastructure\Controllers;

use App\Application\Exceptions\UserNotFoundException;
use App\Application\IsEarlyAdopterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class GetUserEarlyAdopterController extends BaseController
{
    private IsEarlyAdopterService $isEarlyAdopterService;

    public function __construct(IsEarlyAdopterService $isEarlyAdopterService)
    {
        $this->isEarlyAdopterService = $isEarlyAdopterService;
    }

    /**
     * @throws UserNotFoundException
     */
    public function __invoke(string $userEmail): JsonResponse
    {
        $isEarlyAdopter = $this->isEarlyAdopterService->execute($userEmail);

        if ($isEarlyAdopter) {
            return response()->json([
                'early adopter' => 'El usuario es early adopter',
            ], Response::HTTP_OK);
        }

        return response()->json([
            'early adopter' => 'El usuario no es early adopter',
        ], Response::HTTP_OK);
    }
}
