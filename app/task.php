<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class task extends Model
{
    public function task()
    {
        return $this->belongsTo('App\task', 'linked_task_id');
    }
}
