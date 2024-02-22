<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Mockery\Exception;

class CompanyController extends Controller
{
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $companies = Company::orderBy('id', 'ASC')->paginate(10);
        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Company $company): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('companies.show', compact('company'));
    }

    public function edit(Company $company): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:50',
            'cif' => [
                'required',
                'string',
                'size:9',
                'regex:/^[AB]\d{7}[0-9A-B]$/',
                'unique:companies,cif,' . $company->id,
            ],
            'contactName' => 'nullable|string|max:20',
            'companyWeb' => 'nullable|url',
        ]);

        try {
            $company->update($validatedData);
            return redirect()->route('companies.show', $company)->with('success', 'Compañía actualizada correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }


    public function destroy(Company $company): RedirectResponse
    {
        $company->delete();
        return redirect()->route('companies.index')->with('success', 'Compañía eliminada correctamente');
    }
}
