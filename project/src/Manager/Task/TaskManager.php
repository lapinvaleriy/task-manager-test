<?php

namespace App\Manager\Task;

use App\Model\Task\TaskCreateModel;
use App\Repository\Task\TaskRepository;

class TaskManager
{
    /**
     * @var TaskRepository
     */
    private TaskRepository $taskRepository;

    /**
     * TaskManager constructor.
     * @param TaskRepository $taskRepository
     */
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function create(TaskCreateModel $taskCreateModel)
    {
    }
}