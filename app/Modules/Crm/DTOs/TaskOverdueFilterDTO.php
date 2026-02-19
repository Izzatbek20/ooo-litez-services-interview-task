<?php

namespace App\Modules\Crm\DTOs;

use App\Modules\Crm\Enums\TaskPriorityEnum;
use App\Modules\Crm\Enums\TaskStatusEnum;
use App\Modules\Crm\Enums\TaskTypeEnum;
use App\Modules\Crm\Requests\ClientFilterRequest;
use App\Modules\Crm\Requests\TaskFilterRequest;
use App\Modules\Crm\Requests\TaskOverdueFilterRequest;
use Carbon\Carbon;

readonly class TaskOverdueFilterDTO
{
    public function __construct(
        public ?int $perPage,
        public ?string $cursor,
    ) {
    }

    public static function fromRequest(TaskOverdueFilterRequest $request): self
    {
        return new self(
            $request->query('perPage', 10),
            $request->query('cursor', null),
        );
    }

    public function toArray()
    {
        return [
            'perPage' => $this->perPage,
            'cursor' => $this->cursor,
        ];
    }
}
