<?php

namespace App\Controller\Task;

use App\Manager\Task\TaskManager;
use App\Message\TaskCreateMessage;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

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
     * @var Security
     */
    private Security $security;

    /**
     * TaskController constructor.
     *
     * @param TaskManager         $taskManager
     * @param MessageBusInterface $messageBus
     * @param Security            $security
     */
    public function __construct(TaskManager $taskManager, MessageBusInterface $messageBus, Security $security)
    {
        $this->taskManager = $taskManager;
        $this->messageBus  = $messageBus;
        $this->security = $security;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @Route("/create", name="task_create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $this->messageBus->dispatch(
            new TaskCreateMessage(
                $this->security->getUser(),
                $request->get('title'),
                $request->get('description')
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