<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index(Request $request)
    {
        $query = Section::with('class');
        
        if ($request->has('class_id') && $request->class_id != '') {
            $query->where('class_id', $request->class_id);
        }
        
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', "%{$request->search}%");
        }
        
        $sections = $query->orderBy('name')->paginate(10);
        $classes = Classes::all();
        
        return view('admin.sections.index', compact('sections', 'classes'));
    }

    public function create()
    {
        $classes = Classes::all();
        return view('admin.sections.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'class_id' => 'required|exists:classes,id',
            'capacity' => 'required|integer|min:1|max:100'
        ]);

        Section::create($request->all());

        return redirect()->route('admin.sections.index')
            ->with('success', 'Section created successfully.');
    }

    public function show(Section $section)
    {
        $section->load(['class', 'students']);
        $totalStudents = $section->students->count();
        return view('admin.sections.show', compact('section', 'totalStudents'));
    }

    public function edit(Section $section)
    {
        $classes = Classes::all();
        return view('admin.sections.edit', compact('section', 'classes'));
    }

    public function update(Request $request, Section $section)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'class_id' => 'required|exists:classes,id',
            'capacity' => 'required|integer|min:1|max:100'
        ]);

        $section->update($request->all());

        return redirect()->route('admin.sections.index')
            ->with('success', 'Section updated successfully.');
    }

    public function destroy(Section $section)
    {
        if ($section->students()->count() > 0) {
            return redirect()->route('admin.sections.index')
                ->with('error', 'Cannot delete section with enrolled students.');
        }
        
        $section->delete();

        return redirect()->route('admin.sections.index')
            ->with('success', 'Section deleted successfully.');
    }
}