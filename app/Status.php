<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public $fillable = ['name'];
    public function task()
    {
        return $this->hasMany('App\Task');
    }
}
