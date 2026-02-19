<?php

namespace App\Modules\Crm\Enums;

enum TaskStatusEnum: string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case DONE = 'done';
    case CANCELLED = 'cancelled';

    public function accessStatusChange()
    {
        return match ($this) {
            self::PENDING => [self::IN_PROGRESS, self::CANCELLED],
            self::IN_PROGRESS => [self::DONE, self::CANCELLED],
            self::DONE => [],
            self::CANCELLED => []
        };
    }

    public function checkChange(TaskStatusEnum $status): bool
    {
        return in_array($status, $this->accessStatusChange());
    }
}
