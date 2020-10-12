<?php

namespace App\MessageHandler;

use App\Common\Doctrine\Flusher;
use App\Manager\Task\TaskManager;
use App\Message\TaskCreateMessage;
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

    public function __construct(TaskManager $taskManager, Flusher $flusher)
    {
        $this->taskManager = $taskManager;
        $this->flusher = $flusher;
    }

    public function __invoke(TaskCreateMessage $taskCreateMessage)
    {
        $this->taskManager->create(
            $taskCreateMessage->getCreator(),
            $taskCreateMessage->getTitle(),
            $taskCreateMessage->getDescription()
        );

        $this->flusher->flush();
    }
}