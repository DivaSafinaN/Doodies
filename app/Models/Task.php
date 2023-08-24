<?php

namespace App\Models;

use App\Mail\TaskReminder;
use App\Traits\WablasTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Task extends Model
{
    use HasFactory, SoftDeletes;
    use WablasTrait;

    protected $fillable = 
    [
        'user_id',
        'task_group_id',
        'priority_id',
        'task_name',
        'notes',
        'due_date',
        'file',
        'completed',
        'add_to_myday',
        'reminder',
        'start_date',
        'end_date',
        'deleted_at'
    ];

    public function taskGroup()
    {
        return $this->belongsTo(TaskGroup::class);
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function priority(){
        return $this->hasOne(Priority::class);
    }

    public function sendReminderEmail()
    {
        Mail::to($this->user->email)
            ->send(new TaskReminder($this));
    }

    
}
