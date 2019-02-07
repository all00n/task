<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function getRoles(){
        return response()->json(Roles::all());
    }
}
