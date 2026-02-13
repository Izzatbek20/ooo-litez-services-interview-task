<?php

namespace App\Modules\Crm\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
