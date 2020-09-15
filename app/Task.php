<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public $fillable = ['task_name', 'task_description', 'status_id', 'add_date', 'completed_date'];
    public function status()
    {
        return $this->belongsTo('App\Status');
    }
}
