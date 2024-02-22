<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\JobOffer;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class JobOfferController extends Controller
{
    public function indexByCompany(string $idCompany): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $jobOffers = JobOffer::where('company_id',$idCompany)->orderBy('id','ASC')->paginate(10);
        return view('jobOffers.indexByCompany', compact('jobOffers'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(JobOffer $jobOffer): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('jobOffers.show', compact('jobOffer'));
    }

    public function edit(Company $company): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('companies.edit', compact('company'));
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
