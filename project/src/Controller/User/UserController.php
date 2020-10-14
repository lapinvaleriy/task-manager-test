<?php

namespace App\Controller\User;

use App\Entity\User\User;
use App\Repository\User\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 *
 * @Route("/api/v1/user")
 */
class UserController
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * UserController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/create-token/{email}", name="create_token", methods={"POST"})
     */
    public function createToken(string $email): JsonResponse
    {
        /** @var User $user */
        $user = $this->userRepository->findBy(['email' => $email]);
        if (!$user) {
            new JsonResponse("User with email {$email} not found", Response::HTTP_NOT_FOUND);
        }

        //generate token
        $user->setApiToken('');

        return new JsonResponse('', Response::HTTP_CREATED);
    }
}