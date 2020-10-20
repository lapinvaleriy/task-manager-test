<?php

namespace App\Message;

use App\Entity\Task\Task;

class TaskChangeStatusMessage
{
    private Task $task;

    private string $status;

    public function __construct(Task $task, string $status)
    {
        $this->task = $task;
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return Task
     */
    public function getTask(): Task
    {
        return $this->task;
    }
}