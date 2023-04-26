<?php

namespace App\Models;

use App\Mail\MyDayReminder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;

class MyDay extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id','priority_id','name', 'notes','file','due_date','completed','reminder','deleted_at','task_group_id'];

    public function priority(){
        return $this->hasOne(Priority::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function taskGroup(){
        return $this->belongsTo(TaskGroup::class);
    }
    public function sendReminderEmail()
    {
        Mail::to($this->user->email)
            ->send(new MyDayReminder($this));
    }
}
