<?php

namespace App\Controller\Task;

use App\DTOTransformer\Task\TaskDTOTransformer;
use App\Entity\Task\Task;
use App\Model\Task\TaskChangeStatusModel;
use App\Model\Task\TaskCreateModel;
use App\Repository\Task\TaskRepository;
use App\Service\Task\TaskCreator;
use App\Service\Task\TaskStatusChanger;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TaskController
 *
 * @Route("/api/v1/task")
 */
class TaskController extends AbstractFOSRestController
{
    /**
     * @var TaskRepository
     */
    private TaskRepository $taskRepository;

    /**
     * @var TaskDTOTransformer
     */
    private TaskDTOTransformer $taskDTOTransformer;
    /**
     * @var Security
     */
    private Security $security;

    /**
     * @var TaskCreator
     */
    private TaskCreator $taskCreator;

    /**
     * @var TaskStatusChanger
     */
    private TaskStatusChanger $taskStatusChanger;

    /**
     * TaskController constructor.
     *
     * @param TaskCreator $taskCreator
     * @param TaskStatusChanger $taskStatusChanger
     * @param TaskRepository $taskRepository
     * @param TaskDTOTransformer $taskDTOTransformer
     * @param Security $security
     */
    public function __construct(
        TaskCreator $taskCreator,
        TaskStatusChanger $taskStatusChanger,
        TaskRepository $taskRepository,
        TaskDTOTransformer $taskDTOTransformer,
        Security $security
    )
    {
        $this->taskCreator = $taskCreator;
        $this->taskStatusChanger = $taskStatusChanger;
        $this->taskRepository = $taskRepository;
        $this->taskDTOTransformer = $taskDTOTransformer;
        $this->security = $security;
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
        $this->taskCreator->create($createModel);

        return $this->json([], Response::HTTP_CREATED);
    }

    /**
     * @param TaskChangeStatusModel $changeStatusModel
     *
     * @return JsonResponse
     *
     * @throws \App\Exception\EntityNotFoundException
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @Route("/change-status", name="task_change_status", methods={"POST"})
     */
    public function changeStatus(TaskChangeStatusModel $changeStatusModel): JsonResponse
    {
        $this->taskStatusChanger->changeStatus($changeStatusModel);

        return $this->json([]);
    }

    /**
     * @Route("/get/created", name="get_created_tasks", methods={"GET"})
     */
    public function getAllCreated(): JsonResponse
    {
        $tasks = $this->taskRepository->findBy([
            'creator' => $this->security->getUser()
        ]);

        return $this->json(array_map(function (Task $task) {
            return $this->taskDTOTransformer->transform($task);
        }, $tasks));
    }

    /**
     * @Route("/get/to-perform", name="get_tasks_to_perform", methods={"GET"})
     */
    public function getAllToPerform(): JsonResponse
    {
        $tasks = $this->taskRepository->findBy([
            'performer' => $this->security->getUser()
        ]);

        return $this->json(array_map(function (Task $task) {
            return $this->taskDTOTransformer->transform($task);
        }, $tasks));
    }

    /**
     * @Route("/get/created/{id}", name="get_created_task", methods={"GET"})
     */
    public function getOneCreatedById(int $id): JsonResponse
    {
        $task = $this->taskRepository->getOneCreatedForUserById($this->security->getUser(), $id);

        return $this->json($this->taskDTOTransformer->transform($task));
    }

    /**
     * @Route("/get/to-perform/{id}", name="get_task_to_pefrom", methods={"GET"})
     */
    public function getOneToPerformById(int $id): JsonResponse
    {
        $task = $this->taskRepository->getOneToPerformForUserById($this->security->getUser(), $id);

        return $this->json($this->taskDTOTransformer->transform($task));
    }

    /**
     * @Route("/get/all", name="get_tasks", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $tasks = $this->taskRepository->findAllForUser($this->security->getUser());

        return $this->json(array_map(function (Task $task) {
            return $this->taskDTOTransformer->transform($task);
        }, $tasks));
    }
}