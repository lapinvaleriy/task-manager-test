<?php

namespace App\Model\Task;

class TaskOutputModel
{
    private int $id;

    private string $status;

    public function __construct(int $id, string $status)
    {
        $this->id = $id;
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}