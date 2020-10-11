<?php

namespace App\Controller\Task;

use App\Manager\Task\TaskManager;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TaskController
 *
 * @Route("/api/v1/task")
 */
class TaskController
{
    /**
     * @var TaskManager
     */
    private TaskManager $taskManager;

    /**
     * TaskController constructor.
     * @param TaskManager $taskManager
     */
    public function __construct(TaskManager $taskManager)
    {
        $this->taskManager = $taskManager;
    }

    /**
     * @Route("/create", name="task_create", methods={"POST"})
     */
    public function create()
    {

    }

    /**
     * @Route("/get/{id}", name="get_task", methods={"GET"})
     */
    public function get(int $id)
    {

    }

    /**
     * @Route("/get", name="get_tasks", methods={"GET"})
     */
    public function getAll()
    {

    }
}