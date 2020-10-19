<?php

namespace App\Tests\Service\User;

use App\Common\Doctrine\Flusher;
use App\Entity\User\User;
use App\Service\User\UserTokenCreator;
use App\Tool\User\TokenGenerator;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class UserTokenCreatorTest extends TestCase
{
    /**
     * @param string $token
     * @throws \Exception
     *
     * @dataProvider createProvider
     */
    public function testCreate(string $token)
    {
        $tokenGenerator = $this->createMock(TokenGenerator::class);
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $flusher = $this->createMock(Flusher::class);
        $user = $this->createMock(User::class);

        $tokenGenerator->expects($this->once())->method('generate')->willReturn($token);
        $user->expects($this->once())->method('setApiToken')->with($token);
        $entityManager->expects($this->once())->method('persist');
        $flusher->expects($this->once())->method('flush');

        $creator = new UserTokenCreator($tokenGenerator, $entityManager, $flusher);
        $createdToken = $creator->create($user);

        $this->assertEquals($createdToken, $token);
    }

    public function createProvider(): array
    {
        return [
            ['123456']
        ];
    }
}