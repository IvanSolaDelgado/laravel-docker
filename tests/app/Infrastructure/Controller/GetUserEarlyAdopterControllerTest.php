<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\UserDataSource\UserDataSource;
use App\Domain\User;
use Mockery;
use Tests\TestCase;

class GetUserEarlyAdopterControllerTest extends TestCase
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
    public function userIsEarlyAdopter()
    {
        $this->userDataSource
            ->expects('findByEmail')
            ->with('email2@email.com')
            ->andReturn(new User('2', 'email2@email.com'));

        $response = $this->get('/api/user/early-adopter/email2@email.com');

        $response->assertOk();
        $response->assertExactJson(['early adopter' => 'El usuario es early adopter']);
    }

    /**
     * @test
     */
    public function userIsNotEarlyAdopter()
    {
        $this->userDataSource
            ->expects('findByEmail')
            ->with('email2@email.com')
            ->andReturn(new User('1002', 'email2@email.com'));

        $response = $this->get('/api/user/early-adopter/email2@email.com');

        $response->assertOk();
        $response->assertExactJson(['early adopter' => 'El usuario no es early adopter']);
    }
}
