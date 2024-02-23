<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Mail\ActivationEmail;
use App\Models\Company;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CompanyController extends Controller
{
    public function index(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $search = $request->input('search');
        $companies = Company::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy('id', 'ASC')
            ->paginate(10);

        return view('companies.index', compact('companies'));
    }


    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('companies.create');
    }

    public function store(CompanyRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $user = User::create([
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
                'address' => $request['address'],
                'accept' => $request['accept'],
                'observations' => $request['observations'],
                'role' => 'company',
                'isActivated' => 0,
            ]);
            do {
                $token = $user->createToken('Personal Access Token')->plainTextToken;
            } while (User::where('token', $token)->exists());

            $user->forceFill([
                'token' => $token,
                'email_verified_at' => now(),
            ])->save();

            $company = Company::create([
                'user_id' => $user->id,
                'name' => $request['name'],
                'cif' => $request['cif'],
                'contactName' => $request['contactName'],
                'companyWeb' => $request['companyWeb'],
            ]);

            Mail::to($user->email)->send(new ActivationEmail($user));

            DB::commit();

            return redirect()->route('companies.show', $company)->with('success', 'Compañía creada correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
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
        $user = User::where('id',$company->user_id)->first();
        $user->delete();
        return redirect()->route('companies.index')->with('success', 'Compañía eliminada correctamente');
    }
}
