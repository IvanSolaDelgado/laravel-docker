<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\UserDataSource\UserDataSource;
use App\Domain\User;
use App\Infrastructure\Controllers\UserListResponseMapper;
use App\Infrastructure\Controllers\UserResponse;
use Mockery;
use Tests\TestCase;

class UserListResponseMapperTest extends TestCase
{
    private UserDataSource $userDataSource;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function emptyResponseForNullUserList()
    {
        $userListResponseMapper = new UserListResponseMapper();

        $userResponse = $userListResponseMapper->map(null);

        $this->assertEmpty($userResponse);
    }


    /**
     * @test
     */
    public function emptyResponseIfNoUsersGiven()
    {
        $userListResponseMapper = new UserListResponseMapper();

        $userResponse = $userListResponseMapper->map([]);

        $this->assertEmpty($userResponse);
    }

    /**
     * @test
     */
    public function userListMapped()
    {
        $userListResponseMapper = new UserListResponseMapper();
        $user = new User(1, 'email@email.com');
        $expectedUserResponse = [new UserResponse($user)];

        $userResponse = $userListResponseMapper->map([$user]);

        $this->assertEquals($expectedUserResponse, $userResponse);
    }
}
