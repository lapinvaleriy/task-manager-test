<?php

namespace App\DTO\Task;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\AccessType("public_method")
 */
class TaskDTO
{
    /**
     * @Serializer\Type("integer")
     *
     * @var int
     */
    private int $id;

    /**
     * @Serializer\Type("string")
     *
     * @var string
     */
    private string $title;

    /**
     * @Serializer\Type("string")
     *
     * @var null|string
     */
    private ?string $description;

    /**
     * @Serializer\Type("string")
     *
     * @var string
     */
    private string $status;

    /**
     * @Serializer\Type("DateTime<Y-m-d H:i:s>")
     *
     * @var \DateTime
     */
    private \DateTime $createdAt;

    public function __construct(int $id, string $title, ?string $description, string $status, \DateTime $createdAt)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
        $this->createdAt = $createdAt;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
}