<?php

namespace App\Controller\Task;

use App\DTOTransformer\Task\TaskDTOTransformer;
use App\Entity\Task\Task;
use App\Model\Task\TaskAssignModel;
use App\Model\Task\TaskChangeStatusModel;
use App\Model\Task\TaskCreateModel;
use App\Repository\Task\TaskRepository;
use App\Service\Task\TaskAssigner;
use App\Service\Task\TaskCreator;
use App\Service\Task\TaskStatusChanger;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class TaskController
 *
 * @Route("/api/v1/task")
 */
class TaskController extends AbstractFOSRestController
{
    /**
     * @var TaskCreator
     */
    private TaskCreator $taskCreator;

    /**
     * @var TaskStatusChanger
     */
    private TaskStatusChanger $taskStatusChanger;

    /**
     * @var TaskAssigner
     */
    private TaskAssigner $taskAssigner;

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
     * TaskController constructor.
     *
     * @param TaskCreator        $taskCreator
     * @param TaskStatusChanger  $taskStatusChanger
     * @param TaskAssigner       $taskAssigner
     * @param TaskRepository     $taskRepository
     * @param TaskDTOTransformer $taskDTOTransformer
     * @param Security           $security
     */
    public function __construct(
        TaskCreator $taskCreator,
        TaskStatusChanger $taskStatusChanger,
        TaskAssigner $taskAssigner,
        TaskRepository $taskRepository,
        TaskDTOTransformer $taskDTOTransformer,
        Security $security
    )
    {
        $this->taskCreator = $taskCreator;
        $this->taskStatusChanger = $taskStatusChanger;
        $this->taskAssigner = $taskAssigner;
        $this->taskRepository = $taskRepository;
        $this->taskDTOTransformer = $taskDTOTransformer;
        $this->security = $security;
    }

    /**
     * @SWG\Post(
     *      tags={"Task"},
     *      summary="Create task",
     *      @SWG\Parameter(
     *          name="X-AUTH-TOKEN",
     *          in="header",
     *          type="string",
     *          description="Auth token",
     *          required=true,
     *       ),
     *       @SWG\Parameter(
     *          name="title",
     *          in="body",
     *          type="string",
     *          description="Task title",
     *          required=true,
     *          @SWG\Schema(type="string")
     *      ),
     *      @SWG\Parameter(
     *          name="description",
     *          in="body",
     *          type="string",
     *          description="Task description",
     *          @SWG\Schema(type="string")
     *      ),
     *      @SWG\Response(
     *          response=201,
     *          description="empty response",
     *      ),
     *      @SWG\Response(
     *          response=400,
     *          description="input fields are not valid",
     *      ),
     *   )
     *
     * @Route("/create", name="task_create", methods={"POST"})
     *
     * @param TaskCreateModel $createModel
     *
     * @return JsonResponse
     */
    public function create(TaskCreateModel $createModel): JsonResponse
    {
        $this->taskCreator->create($createModel);

        return $this->json([], Response::HTTP_CREATED);
    }

    /**
     * @SWG\Post(
     *      tags={"Task"},
     *      summary="Assign task to user",
     *      @SWG\Parameter(
     *          name="X-AUTH-TOKEN",
     *          in="header",
     *          type="string",
     *          description="Auth token",
     *          required=true,
     *       ),
     *      @SWG\Parameter(
     *          name="task_id",
     *          in="body",
     *          type="string",
     *          description="Task id which you would to assign",
     *          required=true,
     *          @SWG\Schema(type="string")
     *      ),
     *      @SWG\Parameter(
     *          name="user_id",
     *          in="body",
     *          type="string",
     *          description="User id to whom you would assign the task",
     *          required=true,
     *          @SWG\Schema(type="string")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="task assigned",
     *      ),
     *      @SWG\Response(
     *          response=400,
     *          description="input fields are not valid",
     *      ),
     *      @SWG\Response(
     *          response=404,
     *          description="task or user not found",
     *      )
     *   )
     *
     * @Route("/assign", name="task_assign", methods={"POST"})
     *
     * @param TaskAssignModel $taskAssignModel
     *
     * @return JsonResponse
     *
     * @throws \App\Exception\EntityNotFoundException
     */
    public function assign(TaskAssignModel $taskAssignModel)
    {
        $this->taskAssigner->assign($taskAssignModel);

        return $this->json([], Response::HTTP_OK);
    }

    /**
     * @SWG\Post(
     *      tags={"Task"},
     *      summary="Change task status",
     *      @SWG\Parameter(
     *          name="X-AUTH-TOKEN",
     *          in="header",
     *          type="string",
     *          description="Auth token",
     *          required=true,
     *       ),
     *       @SWG\Parameter(
     *          name="task_id",
     *          in="body",
     *          type="integer",
     *          description="Task id",
     *          required=true,
     *          @SWG\Schema(type="string")
     *      ),
     *       @SWG\Parameter(
     *          name="status",
     *          in="body",
     *          type="string",
     *          description="New status",
     *          required=true,
     *          @SWG\Schema(type="string")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="empty response",
     *      ),
     *      @SWG\Response(
     *          response=404,
     *          description="task not found or status does not exists",
     *      ),
     *    )
     *
     * @Route("/change-status", name="task_change_status", methods={"POST"})
     *
     * @param TaskChangeStatusModel $changeStatusModel
     *
     * @return JsonResponse
     *
     * @throws \App\Exception\EntityNotFoundException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function changeStatus(TaskChangeStatusModel $changeStatusModel): JsonResponse
    {
        $this->taskStatusChanger->changeStatus($changeStatusModel);

        return $this->json([]);
    }

    /**
     * @SWG\Get(
     *      tags={"Task"},
     *      summary="Get list of created tasks by user",
     *      @SWG\Parameter(
     *          name="X-AUTH-TOKEN",
     *          in="header",
     *          type="string",
     *          description="Auth token",
     *          required=true,
     *       ),
     *      @SWG\Response(
     *          response=200,
     *          description="Array of objects",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=App\DTO\Task\TaskDTO::class))
     *          )
     *      )
     *  )
     *
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
     * @SWG\Get(
     *      tags={"Task"},
     *      summary="Get list of tasks to perform",
     *      @SWG\Parameter(
     *          name="X-AUTH-TOKEN",
     *          in="header",
     *          type="string",
     *          description="Auth token",
     *          required=true,
     *       ),
     *      @SWG\Response(
     *          response=200,
     *          description="Array of objects",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=App\DTO\Task\TaskDTO::class))
     *          )
     *      )
     *  )
     *
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
     * @SWG\Get(
     *      tags={"Task"},
     *      summary="Get created task by id",
     *      @SWG\Parameter(
     *          name="X-AUTH-TOKEN",
     *          in="header",
     *          type="string",
     *          description="Auth token",
     *          required=true,
     *       ),
     *      @SWG\Response(
     *          response=200,
     *          description="Task object",
     *          @SWG\Schema(ref=@Model(type=App\DTO\Task\TaskDTO::class))
     *      ),
     *      @SWG\Response(
     *          response=404,
     *          description="task not found",
     *      ),
     *  )
     *
     * @Route("/get/created/{id}", name="get_created_task", methods={"GET"})
     *
     * @param int $id
     *
     * @return JsonResponse
     *
     * @throws \App\Exception\EntityNotFoundException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getOneCreatedById(int $id): JsonResponse
    {
        $task = $this->taskRepository->getOneCreatedForUserById($this->security->getUser(), $id);

        return $this->json($this->taskDTOTransformer->transform($task));
    }

    /**
     * @SWG\Get(
     *      tags={"Task"},
     *      summary="Get task to perform by id",
     *      @SWG\Parameter(
     *          name="X-AUTH-TOKEN",
     *          in="header",
     *          type="string",
     *          description="Auth token",
     *          required=true,
     *       ),
     *      @SWG\Response(
     *          response=200,
     *          description="Task object",
     *          @SWG\Schema(ref=@Model(type=App\DTO\Task\TaskDTO::class))
     *      ),
     *      @SWG\Response(
     *          response=404,
     *          description="task not found",
     *      ),
     *  )
     *
     * @Route("/get/to-perform/{id}", name="get_task_to_pefrom", methods={"GET"})
     *
     * @param int $id
     *
     * @return JsonResponse
     *
     * @throws \App\Exception\EntityNotFoundException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getOneToPerformById(int $id): JsonResponse
    {
        $task = $this->taskRepository->getOneToPerformForUserById($this->security->getUser(), $id);

        return $this->json($this->taskDTOTransformer->transform($task));
    }

    /**
     * @SWG\Get(
     *      tags={"Task"},
     *      summary="Get list of all created tasks by user and tasks to perform for user",
     *      @SWG\Parameter(
     *          name="X-AUTH-TOKEN",
     *          in="header",
     *          type="string",
     *          description="Auth token",
     *          required=true,
     *       ),
     *      @SWG\Response(
     *          response=200,
     *          description="Array of objects",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=App\DTO\Task\TaskDTO::class))
     *          )
     *      )
     *  )
     *
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