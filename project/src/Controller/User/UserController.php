<?php

namespace App\Controller\User;

use App\Repository\User\UserRepository;
use App\Service\User\UserTokenCreator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
     * @var UserTokenCreator
     */
    private UserTokenCreator $tokenCreator;

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    public function __construct(UserTokenCreator $tokenCreator, UserRepository $userRepository)
    {
        $this->tokenCreator   = $tokenCreator;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/create-token", name="create_token", methods={"POST"})
     */
    public function createToken(Request $request): JsonResponse
    {
        $email = $request->get('email');
        if (!$email) {
            return new JsonResponse("Email not set", Response::HTTP_NOT_FOUND);
        }

        $user = $this->userRepository->findOneBy(['email' => $email]);
        if (!$user) {
            return new JsonResponse("User with email {$email} not found", Response::HTTP_NOT_FOUND);
        }

        $token = $this->tokenCreator->create($user);

        return new JsonResponse(['token' => $token], Response::HTTP_CREATED);
    }
}