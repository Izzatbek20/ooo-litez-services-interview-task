<?php

namespace App\Modules\Crm\DTOs;

use App\Modules\Crm\Requests\ClientFilterRequest;

readonly class ClientFilterDTO
{
    public function __construct(
        public ?int $perPage,
        public ?string $cursor,
    ) {}

    public static function fromRequest(ClientFilterRequest $request): self
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
