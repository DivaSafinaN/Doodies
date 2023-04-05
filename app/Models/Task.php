<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['task_group_id','priority_id','name', 'notes','due_date','completed','add_to_myday'];

    public function taskGroup()
    {
        return $this->belongsTo(TaskGroup::class);
    }

    public function priority(){
        return $this->hasOne(Priority::class);
    }
}
