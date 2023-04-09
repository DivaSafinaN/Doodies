<?php

namespace App\Models;

use App\Mail\TaskReminder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['task_group_id','priority_id','name', 'notes','due_date','completed','add_to_myday','reminder'];

    public function taskGroup()
    {
        return $this->belongsTo(TaskGroup::class);
    }

    public function priority(){
        return $this->hasOne(Priority::class);
    }

    public function sendReminderEmail()
    {
        Mail::to($this->taskGroup->user->email)
            ->send(new TaskReminder($this));
    }
}
