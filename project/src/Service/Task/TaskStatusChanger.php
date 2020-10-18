<?php

namespace App\Service\Task;

use App\Enum\Task\TaskStatusEnum;
use App\Exception\EntityNotFoundException;
use App\Message\TaskChangeStatusMessage;
use App\Model\Task\TaskChangeStatusModel;
use App\Repository\Task\TaskRepository;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Security\Core\Security;

class TaskStatusChanger
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
     * @var Security
     */
    private Security $security;

    public function __construct(TaskRepository $taskRepository, MessageBusInterface $messageBus, Security $security)
    {
        $this->messageBus = $messageBus;
        $this->security = $security;
        $this->taskRepository = $taskRepository;
    }

    /**
     * @param TaskChangeStatusModel $changeStatusModel
     *
     * @throws EntityNotFoundException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function changeStatus(TaskChangeStatusModel $changeStatusModel)
    {
        $task = $this->taskRepository->getOneToPerformForUserById(
            $this->security->getUser(),
            $taskId = $changeStatusModel->getTaskId()
        );

        if (!in_array($status = $changeStatusModel->getStatus(), TaskStatusEnum::getStatuses())) {
            throw new EntityNotFoundException("Status $status not found");
        }

        if ($task->getStatus() === $status) {
            return;
        }

        $this->messageBus->dispatch(new TaskChangeStatusMessage($task, $status));
    }
}