<?php

namespace App\Http\Controllers;

use App\Models\Cycle;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class CycleController extends Controller
{
    public function indexAll(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $cycles = Cycle::all();
        return view('cycles.index',compact('cycles'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
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
