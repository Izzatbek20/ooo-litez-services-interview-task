<?php

namespace App\Modules\Crm\Requests;

use App\Modules\Crm\Enums\TaskPriorityEnum;
use App\Modules\Crm\Enums\TaskStatusEnum;
use App\Modules\Crm\Enums\TaskTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskTodayFilterRequest extends FormRequest
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
            'perPage' => ['nullable', 'integer'],
            'cursor' => ['nullable', 'string'],
        ];
    }
}
