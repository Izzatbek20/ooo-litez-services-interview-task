<?php

namespace App\Modules\Crm\Controllers;

use App\Modules\Crm\DTOs\ClientFilterDTO;
use App\Modules\Crm\Requests\ClientFilterRequest;
use App\Modules\Crm\Resources\ClientResource;
use App\Modules\Crm\Services\ClientService;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends Controller
{
    public function __construct(
        protected ClientService $client_service
    ) {}

    public function getAll(ClientFilterRequest $clientFilterRequest)
    {

        $filterDTO = ClientFilterDTO::fromRequest($clientFilterRequest);

        $clients = $this->client_service->getAllWithPagination($filterDTO);

        return $this->successWithPagination(ClientResource::collection($clients), 'Mijozlar ro\'yxati', code: Response::HTTP_OK);
    }
}
