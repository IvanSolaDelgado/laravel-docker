<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\UserDataSource\UserDataSource;
use App\Domain\User;
use App\Infrastructure\Persistence\FileUserDataSource;
use Exception;
use Illuminate\Http\Response;
use Mockery;
use Tests\TestCase;

class GetUserListControllerTest extends TestCase
{
    private UserDataSource $userDataSource;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userDataSource = Mockery::mock(UserDataSource::class);
        $this->app->bind(UserDataSource::class, function () {
            return $this->userDataSource; //Inyeccion de dependencias, se inyecta el mock
        });
    }
    /**
     * @test
     */

    public function responseStatus200IfNoUserList()
    {
        $this->userDataSource->expects('getAll')->andReturn([]);
        $response = $this->get('/api/users');


        $response->assertExactJson([]);
    }

    /**
     * @test
     */

    public function getUserList()
    {
        $this->userDataSource->expects('getAll')->andReturn([new User('1', 'email@email.com'),new User('2', 'another_email@email.com')]);
        $response = $this->get('/api/users');

        $response->assertOk();
        $response->assertExactJson(['id1' => 1,'email1' => 'email@email.com', 'id2' => 2, 'email2' => 'another_email@email.com']);
    }
}
