<?php

namespace App\Modules\Crm\Requests;

use App\Modules\Crm\Enums\TaskPriorityEnum;
use App\Modules\Crm\Enums\TaskStatusEnum;
use App\Modules\Crm\Enums\TaskTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskFilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'client_id' => ['nullable', 'exists:clients,id'],
            'type' => ['nullable', Rule::enum(TaskTypeEnum::class)],
            'priority' => ['nullable', Rule::enum(TaskPriorityEnum::class)],
            'status' => ['nullable', Rule::enum(TaskStatusEnum::class)],
            'date_from' => ['nullable', 'required_with:date_to', 'date'],
            'date_to' => ['nullable', 'required_with:date_from', 'date'],
            'perPage' => ['nullable', 'integer'],
            'cursor' => ['nullable', 'string'],
        ];
    }
}
