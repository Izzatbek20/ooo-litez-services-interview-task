<?php

namespace App\Modules\Crm\Services;

use App\Modules\Crm\DTOs\ClientFilterDTO;
use App\Modules\Crm\Models\Client;
use Illuminate\Pagination\CursorPaginator;

class ClientService
{
    public function getAllWithPagination(ClientFilterDTO $clientFilterDTO): CursorPaginator
    {
        return Client::query()->cursorPaginate(perPage: $clientFilterDTO->perPage, cursor: $clientFilterDTO->cursor);
    }
}
