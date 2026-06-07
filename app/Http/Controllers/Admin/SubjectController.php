<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Classes;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Subject::query();
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }
        
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }
        
        $subjects = $query->latest()->paginate(10);
        return view('admin.subjects.index', compact('subjects'));
    }

    public function create()
    {
        $classes = Classes::all();
        $teachers = Teacher::where('status', 'active')->get();
        return view('admin.subjects.create', compact('classes', 'teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:20|unique:subjects,code',
            'type' => 'required|in:theory,practical,both',
            'theory_marks' => 'required|integer|min:0|max:500',
            'practical_marks' => 'required|integer|min:0|max:200',
            'classes' => 'array',
            'teachers' => 'array'
        ]);

        $subject = Subject::create($request->except(['classes', 'teachers']));
        
        if ($request->has('classes')) {
            $subject->classes()->sync($request->classes);
        }
        
        if ($request->has('teachers')) {
            $subject->teachers()->sync($request->teachers);
        }
        
        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject created successfully.');
    }

    public function show(Subject $subject)
    {
        $subject->load(['classes', 'teachers']);
        return view('admin.subjects.show', compact('subject'));
    }

    public function edit(Subject $subject)
    {
        $classes = Classes::all();
        $teachers = Teacher::where('status', 'active')->get();
        return view('admin.subjects.edit', compact('subject', 'classes', 'teachers'));
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:20|unique:subjects,code,' . $subject->id,
            'type' => 'required|in:theory,practical,both',
            'theory_marks' => 'required|integer|min:0|max:500',
            'practical_marks' => 'required|integer|min:0|max:200',
            'classes' => 'array',
            'teachers' => 'array'
        ]);

        $subject->update($request->except(['classes', 'teachers']));
        
        if ($request->has('classes')) {
            $subject->classes()->sync($request->classes);
        }
        
        if ($request->has('teachers')) {
            $subject->teachers()->sync($request->teachers);
        }
        
        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject updated successfully.');
    }

    public function destroy(Subject $subject)
    {
        $subject->classes()->detach();
        $subject->teachers()->detach();
        $subject->delete();
        
        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject deleted successfully.');
    }
}