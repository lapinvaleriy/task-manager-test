<?php

namespace App\Tests\MessageHandler;

use App\Common\Doctrine\Flusher;
use App\Entity\Task\Task;
use App\MessageHandler\TaskChangeStatusHandler;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class TaskChangeStatusHandlerTest extends TestCase
{
    public function testInvoke()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $flusher = $this->createMock(Flusher::class);
        $taskChangeStatusMessage = $this->createMock(TaskChangeStatusHandler::class);
        $task = $this->createMock(Task::class);

        $taskChangeStatusMessage->expects($this->once())->method('getTask')->willReturn($task);
        $task->expects($this->once())->method('setStatus');
        $task->expects($this->once())->method('setUpdatedAt');
        $entityManager->expects($this->once())->method('persist');
        $flusher->expects($this->once())->method('flush');

        (new TaskChangeStatusHandler($entityManager, $flusher))($taskChangeStatusMessage);
    }
}