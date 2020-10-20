<?php

namespace App\MessageHandler;

use App\Common\Doctrine\Flusher;
use App\Message\TaskAssignMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class TaskAssignHandler implements MessageHandlerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var Flusher
     */
    private Flusher $flusher;

    /**
     * TaskStatusChangeHandler constructor.
     * @param EntityManagerInterface $entityManager
     * @param Flusher $flusher
     */
    public function __construct(EntityManagerInterface $entityManager, Flusher $flusher)
    {
        $this->entityManager = $entityManager;
        $this->flusher = $flusher;
    }

    public function __invoke(TaskAssignMessage $taskAssignMessage)
    {
        $task = $taskAssignMessage->getTaskToAssign();

        $task->setPerformer($taskAssignMessage->getAssignTo());
        $task->setUpdatedAt(new \DateTime());

        $this->entityManager->persist($task);
        $this->flusher->flush();
    }
}