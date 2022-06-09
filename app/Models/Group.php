<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory, SoftDeletes;

    public function todos(){
        return $this->hasMany(Todo::class);
    }

    public function users(){
        return $this->belongsToMany(User::class, 'user_groups', 'group_id', 'user_id');
    }
}
