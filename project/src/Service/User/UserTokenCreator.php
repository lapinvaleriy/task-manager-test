<?php

namespace App\Service\User;

use App\Common\Doctrine\Flusher;
use App\Entity\User\User;
use App\Tool\User\TokenGenerator;
use Doctrine\ORM\EntityManagerInterface;

class UserTokenCreator
{
    /**
     * @var TokenGenerator
     */
    private TokenGenerator $tokenGenerator;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var Flusher
     */
    private Flusher $flusher;

    public function __construct(TokenGenerator $tokenGenerator, EntityManagerInterface $entityManager, Flusher $flusher)
    {
        $this->tokenGenerator = $tokenGenerator;
        $this->entityManager = $entityManager;
        $this->flusher = $flusher;
    }

    /**
     * @param User $user
     *
     * @return string
     *
     * @throws \Exception
     */
    public function create(User $user): string
    {
        $token = $this->tokenGenerator->generate();

        $user->setApiToken($token);

        $this->entityManager->persist($user);
        $this->flusher->flush();

        return $token;
    }
}