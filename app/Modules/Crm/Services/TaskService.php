<?php

namespace App\Modules\Crm\Services;

use App\Modules\Crm\DTOs\TaskFilterDTO;
use App\Modules\Crm\DTOs\TaskOverdueFilterDTO;
use App\Modules\Crm\DTOs\TaskStatusUpdateDTO;
use App\Modules\Crm\DTOs\TaskStoreUpdateDTO;
use App\Modules\Crm\DTOs\TaskTodayFilterDTO;
use App\Modules\Crm\Models\Task;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TaskService
{
    public function getAllWithpagination(TaskFilterDTO $taskFilterDTO): CursorPaginator
    {
        $query = Task::query()
            ->when($taskFilterDTO->client_id, function ($q) use ($taskFilterDTO) {
                $q->where('client_id', $taskFilterDTO->client_id);
            })
            ->when($taskFilterDTO->type, function ($q) use ($taskFilterDTO) {
                $q->where('type', $taskFilterDTO->type);
            })
            ->when($taskFilterDTO->priority, function ($q) use ($taskFilterDTO) {
                $q->where('priority', $taskFilterDTO->priority);
            })
            ->when($taskFilterDTO->status, function ($q) use ($taskFilterDTO) {
                $q->where('status', $taskFilterDTO->status);
            })
            ->when($taskFilterDTO->status, function ($q) use ($taskFilterDTO) {
                $q->where('status', $taskFilterDTO->status);
            })
            ->when($taskFilterDTO->date_from && $taskFilterDTO->date_to, function ($q) use ($taskFilterDTO) {
                $q->whereBetween('deadline', [$taskFilterDTO->date_from, $taskFilterDTO->date_to]);
            });

        return $query->cursorPaginate(perPage: $taskFilterDTO->perPage, cursor: $taskFilterDTO->cursor);
    }

    public function getToday(TaskTodayFilterDTO $taskTodayFilterDTO): CursorPaginator
    {
        return Task::query()->whereToday('deadline')->cursorPaginate(perPage: $taskTodayFilterDTO->perPage, cursor: $taskTodayFilterDTO->cursor);
    }

    public function getOverdue(TaskOverdueFilterDTO $taskOverdueFilterDTO): CursorPaginator
    {
        return Task::query()->whereBeforeToday('deadline')->cursorPaginate(perPage: $taskOverdueFilterDTO->perPage, cursor: $taskOverdueFilterDTO->cursor);
    }

    public function updateStatus(int $id, TaskStatusUpdateDTO $taskStatusUpdateDTO)
    {
        $task = Task::query()->findOrFail($id);
        $checkStatusChange = $task->status->checkChange($taskStatusUpdateDTO->status);

        if (!$checkStatusChange) {
            throw ValidationException::withMessages(['status' => "Reja xolatini siz yuborgan xolatga almashtirib bo'lmaydi"]);
        }

        return $task->update($taskStatusUpdateDTO->toArray());
    }

    public function firstById(int $id): ?Task
    {
        return Task::query()->find($id);
    }

    public function existById(int $id): bool
    {
        return Task::query()->where('id', $id)->exists();
    }

    public function create(TaskStoreUpdateDTO $taskStoreUpdateDTO): Task
    {
        $data = array_filter($taskStoreUpdateDTO->toArray());

        return Task::query()->create($data);
    }

    public function update(int $id, TaskStoreUpdateDTO $taskStoreUpdateDTO): bool
    {
        $data = array_filter($taskStoreUpdateDTO->toArray());

        return Task::query()->findOrFail($id)->update($data);
    }

    public function delete(int $id): bool
    {
        return Task::query()->findOrFail($id)->delete();
    }
}
