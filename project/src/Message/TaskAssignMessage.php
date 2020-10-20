<?php

namespace App\Message;

use App\Entity\Task\Task;
use App\Entity\User\User;

class TaskAssignMessage
{
    /**
     * @var User
     */
    private User $assignTo;

    /**
     * @var Task
     */
    private Task $taskToAssign;

    public function __construct(User $assignTo, Task $taskToAssign)
    {
        $this->assignTo = $assignTo;
        $this->taskToAssign = $taskToAssign;
    }

    /**
     * @return User
     */
    public function getAssignTo(): User
    {
        return $this->assignTo;
    }

    /**
     * @return Task
     */
    public function getTaskToAssign(): Task
    {
        return $this->taskToAssign;
    }
}