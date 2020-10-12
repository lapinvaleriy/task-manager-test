<?php

namespace App\MessageHandler;

use App\Common\Doctrine\Flusher;
use App\Manager\Task\TaskManager;
use App\Message\TaskCreateMessage;
use App\Repository\User\UserRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class TaskCreateMessageHandler implements MessageHandlerInterface
{
    /**
     * @var TaskManager
     */
    private TaskManager $taskManager;

    /**
     * @var Flusher
     */
    private Flusher $flusher;
    /**
     * @var UserRepository
     */
    private UserRepository $repository;

    public function __construct(TaskManager $taskManager, Flusher $flusher, UserRepository $repository)
    {
        $this->taskManager = $taskManager;
        $this->flusher = $flusher;
        $this->repository = $repository;
    }

    public function __invoke(TaskCreateMessage $taskCreateMessage)
    {
        $user = $this->repository->find($taskCreateMessage->getCreator());

        $this->taskManager->create(
            $user,
            $taskCreateMessage->getTitle(),
            $taskCreateMessage->getDescription()
        );

        $this->flusher->flush();
    }
}