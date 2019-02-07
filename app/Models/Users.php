<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'patronymic',
        'role_id'
    ];
    protected $with = ['user_roles'];
    public function user_roles(){
        return $this->hasOne('App\Models\Roles', 'id', 'role_id');
    }
}
