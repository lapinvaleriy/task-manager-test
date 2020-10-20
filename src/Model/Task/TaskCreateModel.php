<?php

namespace App\Model\Task;

use Symfony\Component\Validator\Constraints as Assert;

class TaskCreateModel
{
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

    public function __construct(?string $title, ?string $description)
    {
        $this->title = $title;
        $this->description = $description;
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