<?php

namespace App\Common\Doctrine;

use Doctrine\ORM\EntityManagerInterface;

class Flusher
{
    private EntityManagerInterface $entityManager;

    /**
     * Flusher constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function flush()
    {
        $this->entityManager->flush();
    }
}