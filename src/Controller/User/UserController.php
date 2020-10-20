<?php

namespace App\Controller\User;

use App\Repository\User\UserRepository;
use App\Service\User\UserTokenCreator;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 *
 * @Route("/api/v1/user")
 */
class UserController extends AbstractFOSRestController
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
     * @SWG\Post(
     *      tags={"User"},
     *      summary="Create token for user by email",
     *      @SWG\Parameter(
     *          name="email",
     *          in="body",
     *          type="string",
     *          description="User's email",
     *          required=true,
     *          @SWG\Schema(type="string")
     *      ),
     *      @SWG\Response(
     *          response=201,
     *          description="success response",
     *          @SWG\Schema(
     *              type="{'token' => '123456'}"
     *          )
     *      ),
     *      @SWG\Response(
     *          response=400,
     *          description="email not set",
     *      ),
     *      @SWG\Response(
     *          response=404,
     *          description="email not found",
     *      ),
     *    )
     *
     * @Route("/create-token", name="create_token", methods={"POST"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public function createToken(Request $request): JsonResponse
    {
        $email = $request->get('email');
        if (!$email) {
            return new JsonResponse("Email not set", Response::HTTP_BAD_REQUEST);
        }

        $user = $this->userRepository->findOneBy(['email' => $email]);
        if (!$user) {
            return new JsonResponse("User with email {$email} not found", Response::HTTP_NOT_FOUND);
        }

        $token = $this->tokenCreator->create($user);

        return $this->json(['token' => $token], Response::HTTP_CREATED);
    }
}