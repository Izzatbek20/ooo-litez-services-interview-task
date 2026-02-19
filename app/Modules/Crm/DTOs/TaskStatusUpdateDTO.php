<?php

namespace App\Modules\Crm\DTOs;

use App\Modules\Crm\Enums\TaskStatusEnum;
use App\Modules\Crm\Requests\TaskStatusUpdateRequest;

readonly class TaskStatusUpdateDTO
{
    public function __construct(
        public TaskStatusEnum $status,
    ) {}

    public static function fromRequest(TaskStatusUpdateRequest $taskStatusUpdateRequest): self
    {
        return new self(
            $taskStatusUpdateRequest->enum('status', TaskStatusEnum::class),
        );
    }

    public function toArray()
    {
        return [
            'status' => $this->status,
        ];
    }
}
