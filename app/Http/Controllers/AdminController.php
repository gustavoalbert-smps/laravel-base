<?php

namespace App\Http\Controllers;

use App\Models\Permissions\Role;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin-menu');
    }

    public function index() 
    {
        $roles = Role::all();

        return view('admin', compact('roles'));
    }
}
