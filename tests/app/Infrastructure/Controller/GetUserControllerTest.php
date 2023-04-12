<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\UserDataSource\UserDataSource;
use App\Domain\User;
use App\Infrastructure\Persistence\FileUserDataSource;
use Exception;
use Illuminate\Http\Response;
use Mockery;
use Tests\TestCase;

class GetUserControllerTest extends TestCase
{
    private UserDataSource $userDataSource;

    protected function setUp(): void //En el Setup hacemos la inyeccion de dependencias y hacemos que cada vez que se llame a UserDataSource se instancie un Mock en vez de  el
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
        $this->userDataSource->expects('findByEmail')->andReturn(null);
        $response = $this->get('/api/user/email@email.com');

        $response->assertNotFound();
        $response->assertExactJson(['error' => 'usuario no encontrado']);
    }

    /**
     * @test
     */

    public function getsUser()
    {
        $this->userDataSource->expects('findByEmail')->andReturn(new User('2', 'email2@email.com'));
        $response = $this->get('/api/user/email@email.com');

        $response->assertOk();
        $response->assertExactJson(['id' => 2,'email' => 'email2@email.com']);
    }
}
