<?php

namespace App\Modules\Crm\Enums;

enum TaskRemindViaEnum: string
{
    case EMAIL = 'email';
    case SMS = 'sms';
}
