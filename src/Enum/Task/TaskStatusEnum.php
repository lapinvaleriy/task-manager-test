<?php

namespace App\Enum\Task;

class TaskStatusEnum
{
    const STATUS_NEW = 'new';
    const STATUS_ASSIGNED = 'assigned';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_DONE = 'done';

    public static function getStatuses(): array
    {
        return [
            self::STATUS_NEW,
            self::STATUS_ASSIGNED,
            self::STATUS_IN_PROGRESS,
            self::STATUS_DONE
        ];
    }
}