<?php

namespace App\Serializer\Task;

use App\Entity\Task\Task;
use App\Model\Task\TaskOutputModel;
use App\Serializer\EntitySerializer;

class TaskSerializer extends EntitySerializer
{
    public function build(Task $task)
    {
        $output = new TaskOutputModel($task->getId(), $task->getStatus());

        return $this->serialize($output);
    }
}