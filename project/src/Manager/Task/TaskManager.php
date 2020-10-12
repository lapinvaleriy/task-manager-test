<?php

namespace App\Manager\Task;

use App\Entity\Task\Task;
use App\Entity\User\User;
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

    public function create(User $creator, string $title, ?string $description): Task
    {
        $task = new Task($creator, $title, $description);

        $this->taskRepository->persist($task);

        return $task;
    }
}