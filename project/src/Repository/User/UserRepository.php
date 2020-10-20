<?php

namespace App\Repository\User;

use App\Entity\User\User;
use App\Exception\EntityNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param int $id
     *
     * @return User
     *
     * @throws EntityNotFoundException
     */
    public function getUserById(int $id): User
    {
        $user = $this->find($id);
        if (!$user) {
            throw new EntityNotFoundException("User with id $id not found");
        }

        return $user;
    }
}