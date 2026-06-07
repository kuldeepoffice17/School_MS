<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\Classes;
class TeacherController extends Controller
{
    // public function index()
    // {
    //     $teachers = Teacher::latest()->paginate(10);
    //     return view('admin.teachers.index', compact('teachers'));
    // }
    public function index(Request $request)
{
    $query = Teacher::query();
    
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%")
              ->orWhere('teacher_id', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }
    
    if ($request->has('status') && $request->status != '') {
        $query->where('status', $request->status);
    }
    
    if ($request->has('gender') && $request->gender != '') {
        $query->where('gender', $request->gender);
    }
    
    $teachers = $query->latest()->paginate(10);
    return view('admin.teachers.index', compact('teachers'));
}

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|unique:teachers',
            'phone' => 'required|string|max:15',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string',
            'qualification' => 'required|string',
            'specialization' => 'required|string',
            'joining_date' => 'required|date',
        ]);

        $data = $request->all();
        $data['teacher_id'] = 'TCH' . date('Y') . str_pad(Teacher::count() + 1, 4, '0', STR_PAD_LEFT);
        
        Teacher::create($data);
        
        return redirect()->route('admin.teachers.index')->with('success', 'Teacher created successfully.');
    }

    public function edit(Teacher $teacher)
    {
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|unique:teachers,email,' . $teacher->id,
            'phone' => 'required|string|max:15',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string',
            'qualification' => 'required|string',
            'specialization' => 'required|string',
            'joining_date' => 'required|date',
        ]);

        $teacher->update($request->all());
        
        return redirect()->route('admin.teachers.index')->with('success', 'Teacher updated successfully.');
    }
    public function show(Teacher $teacher)
    {
        return view('admin.teachers.show', compact('teacher'));
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('admin.teachers.index')->with('success', 'Teacher deleted successfully.');
    }
    public function assignClass(Teacher $teacher)
    {
        $classes = Classes::all();
        return view('admin.teachers.assign-class', compact('teacher', 'classes'));
    }

    public function assignClassStore(Request $request, Teacher $teacher)
    {
        $request->validate([
            'classes' => 'required|array',
            'classes.*' => 'exists:classes,id'
        ]);
        
        $teacher->classes()->sync($request->classes);
        
        return redirect()->route('admin.teachers.index')
            ->with('success', 'Classes assigned successfully.');
    }
}