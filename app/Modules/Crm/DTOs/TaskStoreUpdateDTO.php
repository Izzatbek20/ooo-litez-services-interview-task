<?php

namespace App\Modules\Crm\DTOs;

use App\Modules\Crm\Enums\TaskPriorityEnum;
use App\Modules\Crm\Enums\TaskRecurrenceEnum;
use App\Modules\Crm\Enums\TaskRemindViaEnum;
use App\Modules\Crm\Enums\TaskTypeEnum;
use App\Modules\Crm\Requests\TaskRequest;

readonly class TaskStoreUpdateDTO
{
    public function __construct(
        public TaskTypeEnum $type,
        public string $title,
        public ?string $description,
        public TaskPriorityEnum $priority,
        public int $client_id,
        public string $deadline,
        public ?int $remind_before_minutes,
        public ?TaskRemindViaEnum $remind_via,
        public ?bool $is_recurring,
        public ?TaskRecurrenceEnum $recurrence_type,
    ) {}

    public static function fromRequest(TaskRequest $taskRequest): self
    {
        return new self(
            $taskRequest->enum('type', TaskTypeEnum::class),
            $taskRequest->input('title'),
            $taskRequest->input('description'),
            $taskRequest->enum('priority', TaskPriorityEnum::class),
            $taskRequest->input('client_id'),
            $taskRequest->input('deadline'),
            $taskRequest->input('remind_before_minutes'),
            $taskRequest->enum('remind_via', TaskRemindViaEnum::class),
            $taskRequest->input('is_recurring'),
            $taskRequest->enum('recurrence_type', TaskRecurrenceEnum::class),
        );
    }

    public function toArray()
    {
        return [
            'type' => $this->type,
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->priority,
            'client_id' => $this->client_id,
            'deadline' => $this->deadline,
            'remind_before_minutes' => $this->remind_before_minutes,
            'remind_via' => $this->remind_via,
            'is_recurring' => $this->is_recurring,
            'recurrence_type' => $this->recurrence_type,
        ];
    }
}
