<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['idProject','nome'];

    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}
