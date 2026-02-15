<?php

namespace App\Modules\Crm\DTOs;

use App\Modules\Crm\Requests\ClientFilterRequest;

readonly class ClientFilterDTO
{
    public function __construct(
        public int $perPage,
        public int $page,
    ) {}

    public static function fromRequest(ClientFilterRequest $clientFilterRequest): self
    {
        return new self(
            $clientFilterRequest->query('perPage', 10),
            $clientFilterRequest->query('page', 1),
        );
    }

    public function toArray()
    {
        return [
            'perPage' => $this->perPage,
            'page' => $this->page,
        ];
    }
}
