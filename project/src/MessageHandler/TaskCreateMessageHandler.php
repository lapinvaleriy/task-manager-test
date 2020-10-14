<?php

namespace App\MessageHandler;

use App\Common\Doctrine\Flusher;
use App\Entity\Task\Task;
use App\Message\TaskCreateMessage;
use App\Repository\Task\TaskRepository;
use App\Repository\User\UserRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class TaskCreateMessageHandler implements MessageHandlerInterface
{
    /**
     * @var TaskRepository
     */
    private TaskRepository $taskRepository;

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @var Flusher
     */
    private Flusher $flusher;

    public function __construct(TaskRepository $taskRepository, UserRepository $userRepository, Flusher $flusher)
    {
        $this->taskRepository = $taskRepository;
        $this->flusher = $flusher;
        $this->userRepository = $userRepository;
    }

    public function __invoke(TaskCreateMessage $taskCreateMessage)
    {
        $user = $this->userRepository->find($taskCreateMessage->getCreator());

        $task = new Task($user, $taskCreateMessage->getTitle(), $taskCreateMessage->getDescription());
        $this->taskRepository->persist($task);

        $this->flusher->flush();
    }
}