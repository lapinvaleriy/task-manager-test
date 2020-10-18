<?php

namespace App\Tests\DTOTransformer\Task;

use App\DTO\Task\TaskDTO;
use App\DTOTransformer\Task\TaskDTOTransformer;
use App\Entity\Task\Task;
use PHPUnit\Framework\TestCase;

class TaskDTOTransformerTest extends TestCase
{
    public function testTransform()
    {
        $task = $this->createMock(Task::class);

        $taskDTOTransformer = new TaskDTOTransformer($task);
        $taskDTO = $taskDTOTransformer->transform($task);

        $this->assertInstanceOf(TaskDTO::class, $taskDTO);
        $this->assertEquals($taskDTO->getId(), $task->getId());
        $this->assertEquals($taskDTO->getTitle(), $task->getTitle());
        $this->assertEquals($taskDTO->getStatus(), $task->getStatus());
        $this->assertEquals($taskDTO->getDescription(), $task->getDescription());
        $this->assertEquals($taskDTO->getCreatedAt(), $task->getCreatedAt());
    }
}