<?php

namespace App\Controller\Task;

use App\Message\TaskCreateMessage;
use App\Model\Task\TaskCreateModel;
use App\Repository\Task\TaskRepository;
use App\Serializer\Task\TaskSerializer;
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
     * @var MessageBusInterface
     */
    private MessageBusInterface $messageBus;

    /**
     * @var TaskRepository
     */
    private TaskRepository $taskRepository;

    /**
     * @var TaskSerializer
     */
    private TaskSerializer $serializer;

    /**
     * TaskController constructor.
     *
     * @param MessageBusInterface $messageBus
     * @param TaskRepository $taskRepository
     * @param TaskSerializer $serializer
     */
    public function __construct(MessageBusInterface $messageBus, TaskRepository $taskRepository, TaskSerializer $serializer)
    {
        $this->messageBus = $messageBus;
        $this->taskRepository = $taskRepository;
        $this->serializer = $serializer;
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
     * @Route("/get/created", name="get_created_tasks", methods={"GET"})
     */
    public function getAllCreated()
    {

    }

    /**
     * @Route("/get/to-perform", name="get_tasks_to_perform", methods={"GET"})
     */
    public function getAllToPerform()
    {

    }

    /**
     * @Route("/get/created/{id}", name="get_created_task", methods={"GET"})
     */
    public function getOneCreatedById(int $id)
    {

    }

    /**
     * @Route("/get/to-perform/{id}", name="get_task_to_pefrom", methods={"GET"})
     */
    public function getOneToPerformById(int $id)
    {

    }

    /**
     * @Route("/get/all", name="get_tasks", methods={"GET"})
     */
    public function getAll()
    {
        $task = $this->taskRepository->find(1);

        $this->serializer->build($task);

        $data = [

        ];

        return new JsonResponse($this->serializer->build($task));
    }
}