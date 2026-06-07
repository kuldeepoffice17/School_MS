<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Section;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    // public function index()
    // {
    //     $classes = Classes::with('sections')->get();
    //     return view('admin.classes.index', compact('classes'));
    // }
    public function index(Request $request)
    {
        $query = Classes::with(['sections', 'students']);
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('numeric_name', 'like', "%{$search}%");
            });
        }
        
        $classes = $query->orderBy('numeric_name')->paginate(10);
        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        return view('admin.classes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'numeric_name' => 'required|string|max:10',
        ]);

        Classes::create($request->all());
        
        return redirect()->route('admin.classes.index')->with('success', 'Class created successfully.');
    }

    public function edit(Classes $class)
    {
        return view('admin.classes.edit', compact('class'));
    }

    public function update(Request $request, Classes $class)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'numeric_name' => 'required|string|max:10',
        ]);

        $class->update($request->all());
        
        return redirect()->route('admin.classes.index')->with('success', 'Class updated successfully.');
    }

    public function destroy(Classes $class)
    {
        $class->delete();
        return redirect()->route('admin.classes.index')->with('success', 'Class deleted successfully.');
    }
    public function assignSubject(Classes $class)
    {
        $subjects = Subject::all();
        return view('admin.classes.assign-subject', compact('class', 'subjects'));
    }

    public function assignSubjectStore(Request $request, Classes $class)
    {
        $request->validate([
            'subjects' => 'required|array',
            'subjects.*' => 'exists:subjects,id'
        ]);
        
        $class->subjects()->sync($request->subjects);
        
        return redirect()->route('admin.classes.index')
            ->with('success', 'Subjects assigned successfully.');
    }
}