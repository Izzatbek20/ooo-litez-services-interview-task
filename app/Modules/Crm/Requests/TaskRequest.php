<?php

namespace App\Modules\Crm\Requests;

use App\Modules\Crm\Enums\TaskPriorityEnum;
use App\Modules\Crm\Enums\TaskRecurrenceEnum;
use App\Modules\Crm\Enums\TaskRemindViaEnum;
use App\Modules\Crm\Enums\TaskTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
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
            'type' => ['required', Rule::enum(TaskTypeEnum::class)],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority' => ['required', Rule::enum(TaskPriorityEnum::class)],
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'deadline' => ['required', 'date'],
            'remind_before_minutes' => ['nullable', 'required_with:remind_via', 'integer'],
            'remind_via' => ['nullable', 'required_with:remind_before_minutes', Rule::enum(TaskRemindViaEnum::class)],
            'is_recurring' => ['nullable', 'boolean'],
            'recurrence_type' => ['nullable', 'required_if_accepted:is_recurring', 'prohibited_if_declined:is_recurring', Rule::enum(TaskRecurrenceEnum::class)],
        ];
    }
}
