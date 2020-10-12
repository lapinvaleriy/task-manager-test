<?php

namespace App\Model\Task;

use App\Entity\User\User;
use Symfony\Component\Validator\Constraints as Assert;

class TaskCreateModel
{
    /**
     * @var null|User
     *
     * @Assert\NotNull()
     */
    private ?User $creator;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(max = 255)
     */
    private ?string $title;

    /**
     * @var string|null
     */
    private ?string $description;

    public function __construct(?User $creator, ?string $title, ?string $description)
    {
        $this->creator = $creator;
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * @return User
     */
    public function getCreator(): User
    {
        return $this->creator;
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