<?php

namespace App\Repository\Task;

use App\Entity\Task\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * @param Task $task
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function persist(Task $task)
    {
        $this->getEntityManager()->persist($task);
    }
}