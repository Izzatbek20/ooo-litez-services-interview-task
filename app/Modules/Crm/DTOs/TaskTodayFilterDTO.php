<?php

namespace App\Modules\Crm\DTOs;

use App\Modules\Crm\Requests\TaskTodayFilterRequest;

readonly class TaskTodayFilterDTO
{
    public function __construct(
        public ?int $perPage,
        public ?string $cursor,
    ) {}

    public static function fromRequest(TaskTodayFilterRequest $request): self
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
