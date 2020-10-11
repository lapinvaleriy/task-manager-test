<?php

namespace App\Manager\User;

use App\Repository\User\UserRepository;

class UserManager
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * UserManager constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
}