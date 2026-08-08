<?php

namespace App\Http\Controllers\Learner;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('learner.profile', compact('user'));
    }
}
