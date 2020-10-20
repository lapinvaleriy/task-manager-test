<?php

namespace App\Tests\Service\Task;

use App\Entity\Task\Task;
use App\Entity\User\User;
use App\Exception\EntityNotFoundException;
use App\Message\TaskAssignMessage;
use App\Model\Task\TaskAssignModel;
use App\Repository\Task\TaskRepository;
use App\Repository\User\UserRepository;
use App\Service\Task\TaskAssigner;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class TaskAssignerTest extends TestCase
{
    /**
     * @var UserRepository|MockObject
     */
    private $userRepository;

    /**
     * @var TaskRepository|MockObject
     */
    private $taskRepository;

    /**
     * @var MessageBusInterface|MockObject
     */
    private $messageBus;

    /**
     * @var TaskAssigner|MockObject
     */
    private $taskAssigner;

    protected function setUp()
    {
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->taskRepository = $this->createMock(TaskRepository::class);
        $this->messageBus = $this->createMock(MessageBusInterface::class);

        $this->taskAssigner = new TaskAssigner(
            $this->userRepository,
            $this->taskRepository,
            $this->messageBus
        );
    }

    public function testAssignWhenUserNotFound()
    {
        $assignModel = $this->createMock(TaskAssignModel::class);
        $assignModel->expects($this->once())->method('getUserId');
        $assignModel->expects($this->never())->method('getTaskId');

        $this->expectException(EntityNotFoundException::class);

        $this->userRepository->expects($this->once())
            ->method('getUserById')
            ->withAnyParameters()
            ->willThrowException(new EntityNotFoundException());

        $this->messageBus->expects($this->never())->method('dispatch');

        $this->taskAssigner->assign($assignModel);
    }

    public function testAssignWhenTaskNotFound()
    {
        $assignModel = $this->createMock(TaskAssignModel::class);
        $assignModel->expects($this->once())->method('getUserId');
        $assignModel->expects($this->once())->method('getTaskId');

        $user = $this->createMock(User::class);

        $this->expectException(EntityNotFoundException::class);

        $this->userRepository->expects($this->once())
                             ->method('getUserById')
                             ->withAnyParameters()
                             ->willReturn($user);

        $this->taskRepository->expects($this->once())
                             ->method('getTaskById')
                             ->withAnyParameters()
                             ->willThrowException(new EntityNotFoundException());

        $this->messageBus->expects($this->never())->method('dispatch');

        $this->taskAssigner->assign($assignModel);
    }

    public function testAssignTask()
    {
        $assignModel = $this->createMock(TaskAssignModel::class);
        $assignModel->expects($this->once())->method('getUserId');
        $assignModel->expects($this->once())->method('getTaskId');

        $user = $this->createMock(User::class);
        $task = $this->createMock(Task::class);

        $assignMessage = $this->createMock(TaskAssignMessage::class);

        $this->userRepository->expects($this->once())
                             ->method('getUserById')
                             ->withAnyParameters()
                             ->willReturn($user);

        $this->taskRepository->expects($this->once())
                             ->method('getTaskById')
                             ->withAnyParameters()
                             ->willReturn($task);

        $this->messageBus->expects($this->once())
                         ->method('dispatch')
                         ->willReturn(new Envelope($assignMessage));

        $this->taskAssigner->assign($assignModel);
    }
}