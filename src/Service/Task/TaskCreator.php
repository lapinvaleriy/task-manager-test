<?php

namespace App\Service\Task;

use App\Message\TaskCreateMessage;
use App\Model\Task\TaskCreateModel;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Security\Core\Security;

class TaskCreator
{
    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $messageBus;

    /**
     * @var Security
     */
    private Security $security;

    public function __construct(MessageBusInterface $messageBus, Security $security)
    {
        $this->messageBus = $messageBus;
        $this->security = $security;
    }

    public function create(TaskCreateModel $createModel)
    {
        $user = $this->security->getUser();

        $this->messageBus->dispatch(
            new TaskCreateMessage($user, $createModel->getTitle(), $createModel->getDescription())
        );
    }
}