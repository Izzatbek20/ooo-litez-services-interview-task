<?php

namespace App\Modules\Crm\DTOs;

use App\Modules\Crm\Enums\TaskPriorityEnum;
use App\Modules\Crm\Enums\TaskStatusEnum;
use App\Modules\Crm\Enums\TaskTypeEnum;
use App\Modules\Crm\Requests\ClientFilterRequest;
use App\Modules\Crm\Requests\TaskFilterRequest;
use Carbon\Carbon;

readonly class TaskFilterDTO
{
    public function __construct(
        public ?int $client_id,
        public ?TaskTypeEnum $type,
        public ?TaskPriorityEnum $priority,
        public ?TaskStatusEnum $status,
        public ?Carbon $date_from,
        public ?Carbon $date_to,
        public ?int $perPage,
        public ?string $cursor,
    ) {
    }

    public static function fromRequest(TaskFilterRequest $taskFilterRequest): self
    {
        return new self(
            $taskFilterRequest->query('client_id', null),
            $taskFilterRequest->enum('type', TaskTypeEnum::class),
            $taskFilterRequest->enum('priority', TaskPriorityEnum::class),
            $taskFilterRequest->enum('status', TaskStatusEnum::class),
            $taskFilterRequest->date_from ? Carbon::parse($taskFilterRequest->date_from) : null,
            $taskFilterRequest->date_to ? Carbon::parse($taskFilterRequest->date_to) : null,
            $taskFilterRequest->query('perPage', 10),
            $taskFilterRequest->query('cursor', null),
        );
    }

    public function toArray()
    {
        return [
            'client_id' => $this->client_id,
            'type' => $this->type,
            'priority' => $this->priority,
            'status' => $this->status,
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
            'perPage' => $this->perPage,
            'cursor' => $this->cursor,
        ];
    }
}
