<?php

namespace App\Tests\Service\Task;

use App\Entity\Task\Task;
use App\Entity\User\User;
use App\Enum\Task\TaskStatusEnum;
use App\Exception\EntityNotFoundException;
use App\Message\TaskChangeStatusMessage;
use App\Model\Task\TaskChangeStatusModel;
use App\Repository\Task\TaskRepository;
use App\Service\Task\TaskStatusChanger;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Security\Core\Security;

class TaskStatusChangerTest extends TestCase
{
    /**
     * @var TaskStatusChanger|MockObject
     */
    private $taskStatusChanger;

    /**
     * @var TaskRepository|MockObject
     */
    private $taskRepository;

    /**
     * @var MessageBusInterface|MockObject
     */
    private $messageBus;

    /**
     * @var Security|MockObject
     */
    private $security;

    protected function setUp()
    {
        $this->taskRepository = $this->createMock(TaskRepository::class);
        $this->messageBus = $this->createMock(MessageBusInterface::class);
        $this->security = $this->createMock(Security::class);

        $this->taskStatusChanger = new TaskStatusChanger(
            $this->taskRepository,
            $this->messageBus,
            $this->security
        );
    }

    public function testChangeStatusWhenTestNull()
    {
        $taskChangeStatusModel = $this->createMock(TaskChangeStatusModel::class);
        $user = $this->createMock(User::class);

        $this->security->expects($this->once())
            ->method('getUser')
            ->willReturn($user);

        $this->expectException(EntityNotFoundException::class);

        $this->taskRepository->expects($this->once())
            ->method('getOneToPerformForUserById')
            ->willThrowException(new EntityNotFoundException());

        $this->messageBus->expects($this->never())->method('dispatch');

        $this->taskStatusChanger->changeStatus($taskChangeStatusModel);
    }

    /**
     * @param string $nonExistentStatus
     *
     * @throws EntityNotFoundException
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @dataProvider changeUnexpectedStatusProvider
     */
    public function testChangeStatusWhenStatusDoesNotExist(string $nonExistentStatus)
    {
        $taskChangeStatusModel = $this->createMock(TaskChangeStatusModel::class);
        $user = $this->createMock(User::class);
        $task = $this->createMock(Task::class);

        $this->security->expects($this->once())
                       ->method('getUser')
                       ->willReturn($user);

        $this->taskRepository->expects($this->once())
                             ->method('getOneToPerformForUserById')
                             ->willReturn($task);

        $this->expectException(EntityNotFoundException::class);
        $this->expectExceptionMessage("Status $nonExistentStatus not found");

        $taskChangeStatusModel->expects($this->once())->method('getStatus')->willReturn($nonExistentStatus);
        $task->expects($this->never())->method('getStatus');
        $this->messageBus->expects($this->never())->method('dispatch');

        $this->taskStatusChanger->changeStatus($taskChangeStatusModel);
    }

    public function changeUnexpectedStatusProvider():array
    {
        return [
            ['non-existent_status']
        ];
    }

    /**
     * @param string $status
     *
     * @throws EntityNotFoundException
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @dataProvider changeSameStatusProvider
     */
    public function testChangeStatusIfStatusIsSame(string $status)
    {
        $taskChangeStatusModel = $this->createMock(TaskChangeStatusModel::class);
        $user = $this->createMock(User::class);
        $task = $this->createMock(Task::class);

        $this->security->expects($this->once())
                       ->method('getUser')
                       ->willReturn($user);

        $this->taskRepository->expects($this->once())
                             ->method('getOneToPerformForUserById')
                             ->willReturn($task);

        $taskChangeStatusModel->expects($this->once())->method('getStatus')->willReturn($status);
        $task->expects($this->once())->method('getStatus')->willReturn($status);
        $this->messageBus->expects($this->never())->method('dispatch');

        $this->taskStatusChanger->changeStatus($taskChangeStatusModel);
    }

    public function changeSameStatusProvider():array
    {
        return [
            [TaskStatusEnum::STATUS_IN_PROGRESS]
        ];
    }

    /**
     * @param string $status
     *
     * @throws EntityNotFoundException
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @dataProvider changeStatusProvider
     */
    public function testChangeStatus(string $status)
    {
        $taskChangeStatusMessage = $this->createMock(TaskChangeStatusMessage::class);
        $taskChangeStatusModel = $this->createMock(TaskChangeStatusModel::class);
        $user = $this->createMock(User::class);
        $task = $this->createMock(Task::class);

        $this->security->expects($this->once())
                       ->method('getUser')
                       ->willReturn($user);

        $this->taskRepository->expects($this->once())
                             ->method('getOneToPerformForUserById')
                             ->willReturn($task);

        $taskChangeStatusModel->expects($this->once())->method('getStatus')->willReturn($status);

        $this->messageBus->expects($this->once())
                         ->method('dispatch')
                         ->willReturn(new Envelope($taskChangeStatusMessage));

        $this->taskStatusChanger->changeStatus($taskChangeStatusModel);
    }

    public function changeStatusProvider():array
    {
        return [
            [TaskStatusEnum::STATUS_DONE]
        ];
    }
}