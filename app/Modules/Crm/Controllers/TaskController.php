<?php

namespace App\Modules\Crm\Controllers;

use App\Modules\Crm\DTOs\TaskFilterDTO;
use App\Modules\Crm\DTOs\TaskOverdueFilterDTO;
use App\Modules\Crm\DTOs\TaskStatusUpdateDTO;
use App\Modules\Crm\DTOs\TaskStoreUpdateDTO;
use App\Modules\Crm\DTOs\TaskTodayFilterDTO;
use App\Modules\Crm\Requests\TaskFilterRequest;
use App\Modules\Crm\Requests\TaskOverdueFilterRequest;
use App\Modules\Crm\Requests\TaskRequest;
use App\Modules\Crm\Requests\TaskStatusUpdateRequest;
use App\Modules\Crm\Requests\TaskTodayFilterRequest;
use App\Modules\Crm\Resources\TaskResource;
use App\Modules\Crm\Services\TaskService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TaskController extends Controller
{
    public function __construct(
        protected TaskService $taskService
    ) {
    }

    public function all(TaskFilterRequest $taskFilterRequest)
    {
        $dto = TaskFilterDTO::fromRequest($taskFilterRequest);
        $tasks = $this->taskService->getAllWithpagination(taskFilterDTO: $dto);

        return $this->successWithPagination(TaskResource::collection($tasks), "Barcha rejalar ro'yxati.");
    }

    public function today(TaskTodayFilterRequest $taskTodayFilterRequest)
    {
        $dto = TaskTodayFilterDTO::fromRequest($taskTodayFilterRequest);
        $tasks = $this->taskService->getToday($dto);

        return $this->successWithPagination(TaskResource::collection($tasks), 'Bugungi rejalar.');
    }

    public function overdue(TaskOverdueFilterRequest $taskOverdueFilterRequest)
    {
        $dto = TaskOverdueFilterDTO::fromRequest($taskOverdueFilterRequest);
        $tasks = $this->taskService->getOverdue($dto);

        return $this->successWithPagination(TaskResource::collection($tasks), "Muddati o'tgan rejalar.");
    }

    public function store(TaskRequest $taskRequest)
    {

        $dto = TaskStoreUpdateDTO::fromRequest($taskRequest);
        $task = $this->taskService->create($dto);

        return $this->success(new TaskResource($task), 'Reja muvoffaqiyatli yaratildi.', Response::HTTP_CREATED);
    }

    public function update(TaskRequest $taskRequest, int $id)
    {
        $dto = TaskStoreUpdateDTO::fromRequest($taskRequest);
        $this->taskService->update($id, $dto);

        return $this->success([], "Ushbu ID bo'yicha ma'lumot yangilandi.", Response::HTTP_OK);
    }

    public function updateStatus(int $id, TaskStatusUpdateRequest $taskStatusUpdateRequest)
    {
        $dto = TaskStatusUpdateDTO::fromRequest($taskStatusUpdateRequest);
        $this->taskService->updateStatus($id, $dto);

        return $this->success([], 'Reja holati yangilandi.');
    }

    public function delete(int $id)
    {
        $this->taskService->delete($id);

        return $this->success([], "Ushbu ID bo'yicha ma'lumot o'chirildi.", Response::HTTP_OK);
    }
}
