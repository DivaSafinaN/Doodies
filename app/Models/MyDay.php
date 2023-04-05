<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MyDay extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['priority_id','name', 'notes','due_date','completed'];

    public function priority(){
        return $this->hasOne(Priority::class);
    }
}
