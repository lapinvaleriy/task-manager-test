<?php

namespace App\Controller\User;

use App\Manager\User\UserManager;
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
     * @var UserManager
     */
    private UserManager $userManager;

    /**
     * UserController constructor.
     * @param UserManager $userManager
     */
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @Route("/login", name="user_login", methods={"POST"})
     */
    public function login(): JsonResponse
    {
        return new JsonResponse('hello', Response::HTTP_OK);
    }
}