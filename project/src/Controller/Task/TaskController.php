<?php

namespace App\Controller\Task;

use App\Manager\Task\TaskManager;
use App\Message\TaskCreateMessage;
use App\Model\Task\TaskCreateModel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
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
     * @var MessageBusInterface
     */
    private MessageBusInterface $messageBus;

    /**
     * TaskController constructor.
     *
     * @param TaskManager         $taskManager
     * @param MessageBusInterface $messageBus
     */
    public function __construct(TaskManager $taskManager, MessageBusInterface $messageBus)
    {
        $this->taskManager = $taskManager;
        $this->messageBus = $messageBus;
    }

    /**
     * @param TaskCreateModel $createModel
     *
     * @return JsonResponse
     *
     * @Route("/create", name="task_create", methods={"POST"})
     */
    public function create(TaskCreateModel $createModel): JsonResponse
    {
        $this->messageBus->dispatch(
            new TaskCreateMessage(
                $createModel->getCreator(),
                $createModel->getTitle(),
                $createModel->getDescription()
            )
        );

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