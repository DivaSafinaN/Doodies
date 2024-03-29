<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskGroup extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id','name'];

    public function tasks(){
        return $this->hasMany(Task::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($taskGroup) {
            $taskGroup->tasks()->forceDelete();
        });
    }
}
