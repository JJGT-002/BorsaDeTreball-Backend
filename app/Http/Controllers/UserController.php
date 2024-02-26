<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(User $user): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('users.show', compact('user'));
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
