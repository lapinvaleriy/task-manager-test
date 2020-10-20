<?php

namespace App\Service\Task;

use App\Message\TaskAssignMessage;
use App\Model\Task\TaskAssignModel;
use App\Repository\Task\TaskRepository;
use App\Repository\User\UserRepository;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Security\Core\Security;

class TaskAssigner
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @var TaskRepository
     */
    private TaskRepository $taskRepository;

    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $messageBus;

    /**
     * @var Security
     */
    private Security $security;

    public function __construct(UserRepository $userRepository, TaskRepository $taskRepository, MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
        $this->userRepository = $userRepository;
        $this->taskRepository = $taskRepository;
    }

    /**
     * @param TaskAssignModel $assignModel
     *
     * @throws \App\Exception\EntityNotFoundException
     */
    public function assign(TaskAssignModel $assignModel)
    {
        $this->messageBus->dispatch(
            new TaskAssignMessage(
                $this->userRepository->getUserById($assignModel->getUserId()),
                $this->taskRepository->getTaskById($assignModel->getTaskId())
            )
        );
    }
}