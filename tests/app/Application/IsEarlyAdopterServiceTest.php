<?php

namespace Tests\app\Application;

use App\Application\Exceptions\UserNotFoundException;
use App\Application\IsEarlyAdopterService;
use App\Application\UserDataSource\UserDataSource;
use App\Domain\User;
use App\Infrastructure\Persistence\FileUserDataSource;
use Mockery;
use Tests\TestCase;

class IsEarlyAdopterServiceTest extends TestCase
{
    private UserDataSource $userDataSource;
    private IsEarlyAdopterService $isEarlyAdopterService;

    protected function setUp(): void
    {
        $this->userDataSource = Mockery::mock(UserDataSource::class);
        $this->isEarlyAdopterService = new IsEarlyAdopterService($this->userDataSource);
    }

    /**
     * @test
     */
    public function userNotFoundByEmail()
    {
        $email = 'email@email.com';

        $this->userDataSource
            ->expects('findByEmail')
            ->with($email)
            ->andReturnNull();

        $this->expectException(UserNotFoundException::class);

        $this->isEarlyAdopterService->execute($email);
    }

    /**
     * @test
     */
    public function userIsEarlyAdopter()
    {
        $email = 'email@email.com';
        $user = new User(1, 'email@email.com');

        $this->userDataSource
            ->expects('findByEmail')
            ->with($email)
            ->andReturn($user);

        $isEarlyAdopter = $this->isEarlyAdopterService->execute($email);

        $this->assertTrue($isEarlyAdopter);
    }

    /**
     * @test
     */
    public function userIsNotEarlyAdopter()
    {
        $email = 'email@email.com';
        $user = new User(2000, 'email@email.com');

        $this->userDataSource
            ->expects('findByEmail')
            ->with($email)
            ->andReturn($user);

        $isEarlyAdopter = $this->isEarlyAdopterService->execute($email);

        $this->assertFalse($isEarlyAdopter);
    }
}
