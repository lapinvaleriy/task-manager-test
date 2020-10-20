<?php

namespace App\Repository\Task;

use App\Entity\Task\Task;
use App\Entity\User\User;
use App\Exception\EntityNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

class TaskRepository extends ServiceEntityRepository
{
    /**
     * TaskRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * @param int $id
     *
     * @return object
     *
     * @throws EntityNotFoundException
     */
    public function getTaskById(int $id): Task
    {
        $task = $this->find($id);
        if (!$task) {
            throw new EntityNotFoundException("Task with id $id not found");
        }

        return $task;
    }

    /**
     * @param User $user
     * @param int $id
     *
     * @return Task|null
     *
     * @throws NonUniqueResultException
     * @throws EntityNotFoundException
     */
    public function getOneCreatedForUserById(User $user, int $id): ?Task
    {
        $task = $this->createQueryBuilder('t')
            ->where('t.creator = :user')
            ->andWhere('t.id = :id')
            ->setParameters([
                'user' => $user,
                'id' => $id
            ])
            ->getQuery()
            ->getOneOrNullResult();

        if (!$task) {
            throw new EntityNotFoundException("Task with id $id not found");
        }

        return $task;
    }

    /**
     * @param User $user
     * @param int $id
     *
     * @return Task|null
     *
     * @throws NonUniqueResultException
     * @throws EntityNotFoundException
     */
    public function getOneToPerformForUserById(User $user, int $id): ?Task
    {
        $task = $this->createQueryBuilder('t')
            ->where('t.performer = :user')
            ->andWhere('t.id = :id')
            ->setParameters([
                'user' => $user,
                'id' => $id
            ])
            ->getQuery()
            ->getOneOrNullResult();

        if (!$task) {
            throw new EntityNotFoundException("Task with id $id not found");
        }

        return $task;
    }

    /**
     * @param User $user
     *
     * @return array
     */
    public function findAllForUser(User $user)
    {
        return $this->createQueryBuilder('t')
            ->where('t.creator = :user')
            ->orWhere('t.performer = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}