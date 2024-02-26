<?php

namespace App\Http\Controllers;

use App\Models\Cycle;
use App\Models\JobOffer;
use App\Models\OfferCycle;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class OfferCycleController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $cycles = Cycle::all();
        return view('layouts.chart', compact('cycles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
