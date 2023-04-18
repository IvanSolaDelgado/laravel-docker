<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\UserDataSource\UserDataSource;
use App\Domain\User;
use Mockery;
use Tests\TestCase;

class GetUserControllerTest extends TestCase
{
    private UserDataSource $userDataSource;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userDataSource = Mockery::mock(UserDataSource::class);
        $this->app->bind(UserDataSource::class, function () {
            return $this->userDataSource; //Inyeccion de dependencias
        });
    }
    /**
     * @test
     */
    public function errorIfGivenUserDoesNotExist()
    {
        $this->userDataSource
            ->expects('findByEmail')
            ->with('email@email.com')
            ->andReturn(null);

        $response = $this->get('/api/user/email@email.com');

        $response->assertNotFound();
        $response->assertExactJson(['error' => 'usuario no encontrado']);
    }

    /**
     * @test
     */
    public function getsUserByEmail()
    {
        $this->userDataSource
            ->expects('findByEmail')
            ->with('email@email.com')
            ->andReturn(new User('2', 'email@email.com'));

        $response = $this->get('/api/user/email@email.com');

        $response->assertOk();
        $response->assertExactJson(['id' => 2,'email' => 'email@email.com']);
    }
}
