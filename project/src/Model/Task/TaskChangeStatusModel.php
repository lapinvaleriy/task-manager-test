<?php

namespace App\Model\Task;

use Symfony\Component\Validator\Constraints as Assert;

class TaskChangeStatusModel
{
    /**
     * @var int
     *
     * @Assert\NotNull()
     */
    private ?int $taskId;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     */
    private ?string $status;

    /**
     * TaskChangeStatusModel constructor.
     * @param int $taskId
     * @param string $status
     */
    public function __construct(?int $taskId, ?string $status)
    {
        $this->taskId = $taskId;
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getTaskId(): int
    {
        return $this->taskId;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}