<?php

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 *
 * @ORM\Table(name="user_users")
 * @ORM\Entity(repositoryClass="App\Repository\User\UserRepository")
 */
class User implements UserInterface
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
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private string $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string")
     */
    private string $email;

    /**
     * @var null|string
     *
     * @ORM\Column(name="api_token", type="string", unique=true, nullable=true)
     */
    private ?string $apiToken;

    /**
     * @var
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Task\Task", mappedBy="creator")
     */
    private $createdTasks;

    /**
     * @var
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Task\Task", mappedBy="performer")
     */
    private $tasksToPerform;

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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getApiToken(): ?string
    {
        return $this->apiToken;
    }

    /**
     * @param string|null $apiToken
     */
    public function setApiToken(?string $apiToken): void
    {
        $this->apiToken = $apiToken;
    }

    /**
     * @return mixed
     */
    public function getCreatedTasks()
    {
        return $this->createdTasks;
    }

    /**
     * @param mixed $createdTasks
     */
    public function setCreatedTasks($createdTasks): void
    {
        $this->createdTasks = $createdTasks;
    }

    /**
     * @return mixed
     */
    public function getTasksToPerform()
    {
        return $this->tasksToPerform;
    }

    /**
     * @param mixed $tasksToPerform
     */
    public function setTasksToPerform($tasksToPerform): void
    {
        $this->tasksToPerform = $tasksToPerform;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return '';
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->getName();
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }
}