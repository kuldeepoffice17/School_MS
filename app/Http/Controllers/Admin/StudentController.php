<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Classes;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display a listing of students with filters
     */
    public function index(Request $request)
    {
        $query = Student::with(['class', 'section']);
        
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('admission_no', 'like', "%{$search}%")
                  ->orWhere('roll_no', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        // Filter by class
        if ($request->has('class_id') && $request->class_id != '') {
            $query->where('class_id', $request->class_id);
        }
        
        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        $students = $query->orderBy('created_at', 'desc')->paginate(10);
        $classes = Classes::all();
        
        return view('admin.students.index', compact('students', 'classes'));
    }

    /**
     * Show form to create new student
     */
    public function create()
    {
        $classes = Classes::with('sections')->get();
        return view('admin.students.create', compact('classes'));
    }

    /**
     * Store a new student
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required|string|max:15',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'admission_date' => 'required|date',
            'parent_name' => 'required|string|max:100',
            'parent_phone' => 'required|string|max:15',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Generate unique admission number
        $admission_no = 'ADM' . date('Y') . str_pad(Student::count() + 1, 4, '0', STR_PAD_LEFT);
        
        // Generate roll number for the class
        $roll_no = Student::where('class_id', $request->class_id)->max('roll_no') + 1;
        
        $data = $request->all();
        $data['admission_no'] = $admission_no;
        $data['roll_no'] = $roll_no;
        $data['status'] = 'active';
        
        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = time() . '_' . $photo->getClientOriginalName();
            $path = $photo->storeAs('students/photos', $filename, 'public');
            $data['photo'] = $path;
        }
        
        $student =Student::create($data);
        // dd($student);
        return redirect()->route('admin.students.index')
            ->with('success', 'Student created successfully. Admission No: ' . $admission_no);
    }

    /**
     * Show student details
     */
    public function show(Student $student)
    {
        $student->load(['class', 'section', 'attendances' => function($q) {
            $q->latest()->limit(10);
        }]);
        
        return view('admin.students.show', compact('student'));
    }

    /**
     * Show form to edit student
     */
    public function edit(Student $student)
    {
        $classes = Classes::with('sections')->get();
        $sections = Section::where('class_id', $student->class_id)->get();
        return view('admin.students.edit', compact('student', 'classes', 'sections'));
    }

    /**
     * Update student
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'phone' => 'required|string|max:15',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'admission_date' => 'required|date',
            'parent_name' => 'required|string|max:100',
            'parent_phone' => 'required|string|max:15',
            'status' => 'required|in:active,inactive,graduated,transferred',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();
        
        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($student->photo && Storage::disk('public')->exists($student->photo)) {
                Storage::disk('public')->delete($student->photo);
            }
            
            $photo = $request->file('photo');
            $filename = time() . '_' . $photo->getClientOriginalName();
            $path = $photo->storeAs('students/photos', $filename, 'public');
            $data['photo'] = $path;
        }
        
        $student->update($data);
        
        return redirect()->route('admin.students.index')
            ->with('success', 'Student updated successfully.');
    }

    /**
     * Delete student
     */
    public function destroy(Student $student)
    {
        // Delete photo if exists
        if ($student->photo && Storage::disk('public')->exists($student->photo)) {
            Storage::disk('public')->delete($student->photo);
        }
        
        $student->delete();
        
        return redirect()->route('admin.students.index')
            ->with('success', 'Student deleted successfully.');
    }
    
    /**
     * Get sections for a class (AJAX)
     */
    public function getSections($classId)
    {
        $sections = Section::where('class_id', $classId)->get();
        return response()->json($sections);
    }
}