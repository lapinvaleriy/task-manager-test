<?php

namespace App\Tests\MessageHandler;

use App\Common\Doctrine\Flusher;
use App\Message\TaskCreateMessage;
use App\MessageHandler\TaskCreateMessageHandler;
use App\Repository\User\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class TaskCreateMessageHandlerTest extends TestCase
{
    public function testInvoke()
    {
        $userRepository = $this->createMock(UserRepository::class);
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $flusher = $this->createMock(Flusher::class);
        $taskCreateMessage = $this->createMock(TaskCreateMessage::class);
        $user = $this->createMock(UserRepository::class);

        $userRepository->expects($this->once())->method('find')->willReturn($user);
        $taskCreateMessage->expects($this->once())->method('getTitle');
        $taskCreateMessage->expects($this->once())->method('getDescription');
        $entityManager->expects($this->once())->method('persist');
        $flusher->expects($this->once())->method('flush');

        (new TaskCreateMessageHandler($entityManager, $userRepository, $flusher))($taskCreateMessage);
    }
}