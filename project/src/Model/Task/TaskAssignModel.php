<?php

namespace App\Model\Task;

use Symfony\Component\Validator\Constraints as Assert;

class TaskAssignModel
{
    /**
     * @var int|null
     *
     * @Assert\NotNull()
     */
    private ?int $taskId;

    /**
     * @var int|null
     *
     * @Assert\NotNull()
     */
    private ?int $userId;

    /**
     * TaskAssignModel constructor.
     *
     * @param int|null $taskId
     * @param int|null $userId
     */
    public function __construct(?int $taskId, ?int $userId)
    {
        $this->taskId = $taskId;
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getTaskId(): int
    {
        return $this->taskId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }
}