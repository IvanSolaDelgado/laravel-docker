<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\UserDataSource\UserDataSource;
use App\Domain\User;
use Mockery;
use Tests\TestCase;

class GetGlobalProviderUsersControllerTest extends TestCase
{
    private UserDataSource $userDataSource;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userDataSource = Mockery::mock(UserDataSource::class);
        $this->app->bind(UserDataSource::class, function () {
            return $this->userDataSource;
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

        $response = $this->get('/api/global-provider-users');

        $response->assertExactJson([]);
    }

    /**
     * @test
     */
    public function getGlobalProviderUsersList()
    {
        $this->userDataSource
            ->expects('getAll')
            ->withNoArgs()
            ->andReturn([
                new User(1, "email@gmail.com"),
                new User(2, "email@hotmail.com"),
                new User(3, "another_email@email.com"),
                new User(4, "last_email@email.com"),
                new User(5, "ARROZConPOLLO@gmail.com"),
                new User(6, "TOCAPECHOBRAZO@hotmail.com"),
            ]);

        $response = $this->get('/api/global-provider-users');

        $response->assertOk();
        $response->assertExactJson([
            ['id' => 1, 'email' => 'email@gmail.com'],
            ['id' => 2, 'email' => 'email@hotmail.com'],
            ['id' => 5, 'email' => 'ARROZConPOLLO@gmail.com'],
            ['id' => 6, 'email' => 'TOCAPECHOBRAZO@hotmail.com'],
        ]);
    }

}
