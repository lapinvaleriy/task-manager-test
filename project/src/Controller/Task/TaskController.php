<?php

namespace App\Controller\Task;

use App\Manager\Task\TaskManager;
use App\Model\Task\TaskCreateModel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
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
     * @param TaskCreateModel $taskCreateModel
     *
     * @return JsonResponse
     *
     * @Route("/create", name="task_create", methods={"POST"})
     */
    public function create(TaskCreateModel $taskCreateModel): JsonResponse
    {
        $this->taskManager->create($taskCreateModel);

        return new JsonResponse([], Response::HTTP_CREATED);
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