<?php

namespace App\Modules\Crm\Services;

use App\Modules\Crm\DTOs\ClientFilterDTO;
use App\Modules\Crm\Models\Client;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskService
{
    public function getAllWithPagination(ClientFilterDTO $clientFilterDTO): LengthAwarePaginator
    {
        return Client::query()->paginate(perPage: $clientFilterDTO->perPage, page: $clientFilterDTO->page);
    }
}
