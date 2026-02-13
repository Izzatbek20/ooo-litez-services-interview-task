<?php

namespace App\Modules\Crm\Enums;

enum TaskTypeEnum: string
{
    case CALL = 'call';
    case MEETING = 'meeting';
    case EMAIL = 'email';
    case TASK = 'task';
}
