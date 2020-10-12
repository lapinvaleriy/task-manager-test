<?php

namespace App\Entity\Task;

use App\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Task
 *
 * @ORM\Table(name="task_tasks")
 * @ORM\Entity(repositoryClass="App\Repository\Task\TaskRepository")
 */
class Task
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User", inversedBy="createdTasks")
     * @ORM\JoinColumn(name="creator_id", referencedColumnName="id")
     */
    private User $creator;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User", inversedBy="tasksToPerfmorm")
     * @ORM\JoinColumn(name="performer_id", referencedColumnName="id", nullable=true)
     */
    private ?User $performer;

    /**
     * @var TaskStatus
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Task\TaskStatus")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     */
    private TaskStatus $status;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string")
     */
    private string $title;

    /**
     * @var null|string
     *
     * @ORM\Column(name="decription", type="text", nullable=true)
     */
    private ?string $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private \DateTime $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private \DateTime $updatedAt;

    public function __construct(User $creator, string $title, ?string $description)
    {
        $this->creator = $creator;
        $this->title = $title;
        $this->description = $description;
        $this->createdAt = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getCreator(): User
    {
        return $this->creator;
    }

    /**
     * @param User $creator
     */
    public function setCreator(User $creator): void
    {
        $this->creator = $creator;
    }

    /**
     * @return User|null
     */
    public function getPerformer(): ?User
    {
        return $this->performer;
    }

    /**
     * @param User|null $performer
     */
    public function setPerformer(?User $performer): void
    {
        $this->performer = $performer;
    }

    /**
     * @return TaskStatus
     */
    public function getStatus(): TaskStatus
    {
        return $this->status;
    }

    /**
     * @param TaskStatus $status
     */
    public function setStatus(TaskStatus $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
