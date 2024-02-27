<?php

namespace App\Http\Controllers;

use App\Models\Cycle;
use App\Models\JobOffer;
use App\Models\Student;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function indexStudentsByCycleId($cycleId): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $cycle = Cycle::findOrFail($cycleId);
        $students = $cycle->students()->paginate(10);

        return view('students.indexStudentsByCycleId', compact('students','cycleId'));
    }

    public function indexJobOffersByCycle($cycleId): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $cycle = Cycle::findOrFail($cycleId);
        $jobOffers = $cycle->jobOffer()->paginate(10);

        return view('students.indexJobOffersByCycle', compact('jobOffers', 'cycleId'));
    }


    public function studentsEnrolledInJobOffer(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $students = Student::whereHas('jobOffer')->orderBy('created_at', 'desc')->get();

        return view('students.studentsEnrolledInJobOffer', compact('students'));
    }


    public function show($studentId): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $student = Student::findOrFail($studentId);
        return view('students.show', compact('student'));
    }

    public function edit($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $student = Student::findOrFail($id);
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $student = Student::findOrFail($id);
        $student->name = $request->input('name');
        $student->surnames = $request->input('surnames');
        $student->urlCV = $request->input('urlCV');
        $student->save();

        return redirect()->route('students.show', $id)->with('success', 'Estudiante actualizado correctamente');
    }

    public function destroy(Student $student, $cycleId): RedirectResponse {
        $user = User::where('id',$student->user_id)->first();
        $user->delete();
        return redirect()->route('students.indexStudentsByCycleId',$cycleId)->with('success', 'Estudiante eliminado correctamente');
    }
}
