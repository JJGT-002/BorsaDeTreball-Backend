<?php

namespace App\Http\Controllers;

use App\Models\Cycle;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class CycleController extends Controller
{
    public function index(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $search = $request->input('search');

        if ($search) {
            $cycles = Cycle::where('ciclo', 'LIKE', "%$search%")->paginate(10);
        } else {
            $cycles = Cycle::paginate(10);
        }

        return view('cycles.index', compact('cycles', 'search'));
    }

    public function show($cycleId): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $cycle = Cycle::where('id',$cycleId)->first();
        return view('cycles.show', compact('cycle'));
    }
}
