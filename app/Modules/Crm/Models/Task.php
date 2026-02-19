<?php

namespace App\Modules\Crm\Models;

use App\Modules\Crm\Enums\TaskPriorityEnum;
use App\Modules\Crm\Enums\TaskRecurrenceEnum;
use App\Modules\Crm\Enums\TaskRemindViaEnum;
use App\Modules\Crm\Enums\TaskStatusEnum;
use App\Modules\Crm\Enums\TaskTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'client_id',
        'type',
        'title',
        'description',
        'priority',
        'status',
        'deadline',
        'is_recurring',
        'recurrence_type',
        'remind_before_minutes',
        'remind_via',
    ];

    protected $attributes = [
        'is_recurring' => false,
        'status' => TaskStatusEnum::PENDING->value,
    ];

    protected $casts = [
        'type' => TaskTypeEnum::class,
        'priority' => TaskPriorityEnum::class,
        'status' => TaskStatusEnum::class,
        'deadline' => 'datetime',
        'is_recurring' => 'boolean',
        'recurrence_type' => TaskRecurrenceEnum::class,
        'remind_via' => TaskRemindViaEnum::class,
        'reminder_sent_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public static function booted()
    {
        static::creating(function (Task $task) {
            $task->user_id = Auth::id();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
