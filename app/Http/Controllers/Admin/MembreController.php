<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MembreController extends Controller
{
    public function index()
    {
        $users = \App\Models\User::with('profil')->latest()->paginate(5);
        return view('admin.membres.index', compact('users'));
    }
}
