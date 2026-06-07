<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    public function index()
    {
        $academicYears = AcademicYear::orderBy('start_date', 'desc')->paginate(10);
        return view('admin.academic-years.index', compact('academicYears'));
    }

    public function create()
    {
        return view('admin.academic-years.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:academic_years,name',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // If this is set as current, remove current from others
        if ($request->has('is_current')) {
            AcademicYear::where('is_current', 1)->update(['is_current' => 0]);
        }

        AcademicYear::create($request->all());

        return redirect()->route('admin.academic-years.index')
            ->with('success', 'Academic Year created successfully.');
    }

    public function edit(AcademicYear $academicYear)
    {
        return view('admin.academic-years.edit', compact('academicYear'));
    }

    public function update(Request $request, AcademicYear $academicYear)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:academic_years,name,' . $academicYear->id,
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // If this is set as current, remove current from others
        if ($request->has('is_current')) {
            AcademicYear::where('id', '!=', $academicYear->id)
                ->where('is_current', 1)
                ->update(['is_current' => 0]);
        }

        $academicYear->update($request->all());

        return redirect()->route('admin.academic-years.index')
            ->with('success', 'Academic Year updated successfully.');
    }

    public function destroy(AcademicYear $academicYear)
    {
        // Check if has exams
        if ($academicYear->exams()->count() > 0) {
            return redirect()->route('admin.academic-years.index')
                ->with('error', 'Cannot delete academic year with associated exams.');
        }

        $academicYear->delete();

        return redirect()->route('admin.academic-years.index')
            ->with('success', 'Academic Year deleted successfully.');
    }

    public function setCurrent(AcademicYear $academicYear)
    {
        AcademicYear::where('is_current', 1)->update(['is_current' => 0]);
        $academicYear->update(['is_current' => 1]);

        return redirect()->route('admin.academic-years.index')
            ->with('success', 'Current academic year set successfully.');
    }
}