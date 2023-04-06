<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MyDay extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id','priority_id','name', 'notes','due_date','completed'];

    public function priority(){
        return $this->hasOne(Priority::class);
    }

    public function users(){
        return $this->belongsTo(User::class);
    }
}
