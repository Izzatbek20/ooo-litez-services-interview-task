<?php

use App\Modules\Crm\Enums\TaskPriorityEnum;
use App\Modules\Crm\Enums\TaskRecurrenceEnum;
use App\Modules\Crm\Enums\TaskRemindViaEnum;
use App\Modules\Crm\Enums\TaskStatusEnum;
use App\Modules\Crm\Enums\TaskTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->enum('type', TaskTypeEnum::cases());
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('priority', TaskPriorityEnum::cases());
            $table->enum('status', TaskStatusEnum::cases())->default('pending');
            $table->dateTime('deadline');
            $table->boolean('is_recurring')->default(false)->comment("Vazifa tugalangandan so'ng qayta takrorlanishi");
            $table->enum('recurrence_type', TaskRecurrenceEnum::cases())->nullable();
            $table->integer('remind_before_minutes')->nullable()->comment('Muddatga N daqiqa qolganda eslatma yuborish.');
            $table->enum('remind_via', TaskRemindViaEnum::cases())->nullable()->comment('Eslatma kanali');
            $table->dateTime('reminder_sent_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
