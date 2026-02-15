<?php

namespace App\Modules\Crm\Controllers;

use App\Modules\Crm\Services\TaskService;

class TaskController extends Controller
{
    public function __construct(
        protected TaskService $taskService
    ) {}

}
