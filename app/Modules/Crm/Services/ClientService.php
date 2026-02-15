<?php

namespace App\Modules\Crm\Services;

use App\Modules\Crm\DTOs\ClientFilterDTO;
use App\Modules\Crm\DTOs\UserDTO;
use App\Modules\Crm\Models\Client;
use App\Modules\Crm\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class ClientService
{
    public function getAllWithPagination(ClientFilterDTO $clientFilterDTO): LengthAwarePaginator
    {
        return Client::query()->paginate(perPage: $clientFilterDTO->perPage, page: $clientFilterDTO->page);
    }
}
