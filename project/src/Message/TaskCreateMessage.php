<?php

namespace App\Message;

use App\Entity\User\User;

class TaskCreateMessage
{
    private User $creator;

    private string $title;

    private ?string $description;

    public function __construct(User $creator, string $title, ?string $description)
    {
        $this->creator = $creator;
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * @return User
     */
    public function getCreator()
    {
        return $this->creator->getId();
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
}