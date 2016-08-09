<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['idCreator','nome'];

    public function creator()
    {
        return $this->belongsTo('App\User', 'idCreator');
    }

    public function tasks()
    {
        return $this->hasMany('App\Task', 'idProject');
    }
}
