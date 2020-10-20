<?php

namespace App\MessageHandler;

use App\Common\Doctrine\Flusher;
use App\Entity\Task\Task;
use App\Message\TaskCreateMessage;
use App\Repository\User\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class TaskCreateMessageHandler implements MessageHandlerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @var Flusher
     */
    private Flusher $flusher;

    /**
     * TaskCreateMessageHandler constructor.
     * @param EntityManagerInterface $entityManager
     * @param UserRepository $userRepository
     * @param Flusher $flusher
     */
    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository, Flusher $flusher)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->flusher = $flusher;
    }

    public function __invoke(TaskCreateMessage $taskCreateMessage)
    {
        $user = $this->userRepository->find($taskCreateMessage->getCreator());

        $task = new Task($user, $taskCreateMessage->getTitle(), $taskCreateMessage->getDescription());

        $this->entityManager->persist($task);
        $this->flusher->flush();
    }
}