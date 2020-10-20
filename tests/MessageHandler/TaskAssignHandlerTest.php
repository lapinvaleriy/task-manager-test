<?php

namespace App\Tests\MessageHandler;

use App\Common\Doctrine\Flusher;
use App\Entity\Task\Task;
use App\Entity\User\User;
use App\Message\TaskAssignMessage;
use App\MessageHandler\TaskAssignHandler;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class TaskAssignHandlerTest extends TestCase
{
    public function testInvoke()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $flusher = $this->createMock(Flusher::class);
        $taskAssignMessage = $this->createMock(TaskAssignMessage::class);
        $task = $this->createMock(Task::class);
        $user = $this->createMock(User::class);

        $taskAssignMessage->expects($this->once())->method('getTaskToAssign')->willReturn($task);
        $taskAssignMessage->expects($this->once())->method('getAssignTo')->willReturn($user);

        $task->expects($this->once())->method('setPerformer')->with($user);
        $task->expects($this->once())->method('setUpdatedAt');
        $entityManager->expects($this->once())->method('persist');
        $flusher->expects($this->once())->method('flush');

        (new TaskAssignHandler($entityManager, $flusher))($taskAssignMessage);
    }

}