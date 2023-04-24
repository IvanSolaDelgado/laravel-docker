<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\UserDataSource\UserDataSource;
use App\Domain\User;
use Mockery;
use Tests\TestCase;

class GetSpecialUserTest extends TestCase
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
    public function emptyListIfNoUserFound()
    {
        $this->userDataSource
            ->expects('getAll')
            ->withNoArgs()
            ->andReturn([]);

        $response = $this->get('/api/special-users');

        $response->assertExactJson([]);
    }

    /**
     * @test
     */
    public function getSpecialUsersList()
    {
        $this->userDataSource
            ->expects('getAll')
            ->andReturn([
                new User('1', 'email@email.com'),
                new User('2', 'another_email@email.com'),
                new User('5', 'another_email2@email.com'),
                new User('25', 'arrozConPollo@email.com')
            ]);

        $response = $this->get('/api/special-users');

        $response->assertOk();
        $response->assertExactJson([
                ['id' => 2, 'email' => 'another_email@email.com'],
                ['id' => 5, 'email' => 'another_email2@email.com'],
                ['id' => 25, 'email' => 'arrozConPollo@email.com']
            ]);
    }
}
