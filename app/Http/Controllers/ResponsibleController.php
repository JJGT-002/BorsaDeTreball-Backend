<?php

namespace App\Http\Controllers;

use App\Models\Cycle;
use App\Models\ResponsibleCycle;
use App\Models\User;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResponsibleController extends Controller
{

    public function index(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $search = $request->input('search');

        if ($search) {
            $responsibles = User::where('role', 'responsible')
                ->where(function ($query) use ($search) {
                    $query->where('email', 'LIKE', "%$search%")
                        ->orWhere('address', 'LIKE', "%$search%")
                        ->orWhere('observations', 'LIKE', "%$search%");
                })
                ->get();
        } else {
            $responsibles = User::where('role', 'responsible')->get();
        }

        return view('responsibles.index', compact('responsibles', 'search'));
    }

    public function getCyclesByResponsibleUserId($responsibleId, Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $search = $request->input('search');

        $user = User::findOrFail($responsibleId);
        $cyclesByResponsibleUserId = $user->cycles();

        if ($search) {
            $cyclesByResponsibleUserId->where('ciclo', 'like', '%' . $search . '%');
        }

        $cyclesByResponsibleUserId = $cyclesByResponsibleUserId->paginate(10);

        $showRemoveButton = true;

        return view('cycles.indexCyclesByResponsibleUserId', compact('cyclesByResponsibleUserId', 'responsibleId', 'search','showRemoveButton'));
    }

    public function getCyclesWithoutResponsible($responsibleId): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $cyclesWithResponsibleIds = DB::table('responsible_cycles')->pluck('cycle_id')->toArray();
        $cyclesWithoutResponsible = Cycle::whereNotIn('id', $cyclesWithResponsibleIds)->paginate(10);
        return view('cycles.indexCyclesWithoutResponsible', compact('cyclesWithoutResponsible','responsibleId'));
    }

    public function assignResponsibleWithCycle($responsibleId,$cycleId): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $responsibleCycle = new ResponsibleCycle([
            'responsible_id' => $responsibleId,
            'cycle_id' => $cycleId,
        ]);
        $responsibleCycle->save();
        $cycle = Cycle::where('id',$cycleId)->first();
        return view('cycles.show', compact('cycle'));
    }

    public function delete($responsibleId,$cycleId): RedirectResponse
    {
        DB::table('responsible_cycles')
            ->where('responsible_id', $responsibleId)
            ->where('cycle_id', $cycleId)
            ->delete();
        return redirect()->route('responsibles.indexCyclesByResponsible', $responsibleId)->with('success', 'Eliminada relación entre responsable y ciclo');
    }

    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('responsibles.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'address' => 'required|string',
        ]);

        $observations = $request->input('observations') ?? 'Sin observaciones';

        $responsible = new User([
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'address' => $request->input('address'),
            'observations' => $observations,
            'role' => 'responsible',
            'accept' => 1,
            'isActivated' => 1,
        ]);

        $responsible->save();

        do {
            $token = $responsible->createToken('Personal Access Token')->plainTextToken;
        } while (User::where('token', $token)->exists());

        $responsible->forceFill([
            'token' => $token,
        ])->save();

        return redirect()->route('responsibles.index')->with('success', 'Responsable creado correctamente');
    }

    public function show($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function edit($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $responsible = User::findOrFail($id);
        return view('responsibles.edit', compact('responsible'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $responsible = User::findOrFail($id);
        $responsible->update($request->all());
        return redirect()->route('responsibles.index')->with('success', 'Responsable actualizado correctamente');
    }

    public function destroy(User $responsible): RedirectResponse
    {
        $responsible->delete();
        return redirect()->route('responsibles.index')->with('success', 'Responsable eliminado correctamente');
    }

    public function showCyclesOfAResponsible($responsibleId): View|Application|Factory|\Illuminate\Contracts\Foundation\Application {
        $cycleIds = ResponsibleCycle::where('responsible_id', $responsibleId)->pluck('cycle_id')->toArray();

        $cyclesByResponsibleUserId = Cycle::whereIn('id', $cycleIds)->paginate(10);

        $showRemoveButton = false;

        return view('cycles.indexCyclesByResponsibleUserId', compact('cyclesByResponsibleUserId', 'responsibleId','showRemoveButton'));
    }
}
