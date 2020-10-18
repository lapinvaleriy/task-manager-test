<?php

namespace App\Tests\Service\Task;

use App\Entity\User\User;
use App\Model\Task\TaskCreateModel;
use App\Service\Task\TaskCreator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Security\Core\Security;

class TaskCreatorTest extends TestCase
{
    public function testCreate()
    {
        $messageBus = $this->createMock(MessageBusInterface::class);
        $security = $this->createMock(Security::class);
        $user = $this->createMock(User::class);
        $createModel = $this->createMock(TaskCreateModel::class);

        $security->expects($this->once())->method('getUser')->willReturn($user);
        $messageBus->expects($this->once())->method('dispatch');
        $createModel->expects($this->once())->method('getTitle');
        $createModel->expects($this->once())->method('getDescription');

        $creator = new TaskCreator($messageBus, $security);
        $creator->create($createModel);
    }
}