<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\AcademicYear;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Student;
use App\Models\ExamRoutine;
use App\Models\ExamResult;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $query = Exam::with('academicYear');
        
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', "%{$request->search}%");
        }
        
        if ($request->has('term') && $request->term != '') {
            $query->where('term', $request->term);
        }
        
        $exams = $query->latest()->paginate(10);
        return view('admin.exams.index', compact('exams'));
    }

    public function create()
    {
        $academicYears = AcademicYear::orderBy('start_date', 'desc')->get();
        return view('admin.exams.create', compact('academicYears'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'term' => 'required|in:first_term,second_term,third_term,final',
            'academic_year_id' => 'required|exists:academic_years,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        Exam::create($request->all());

        return redirect()->route('admin.exams.index')
            ->with('success', 'Exam created successfully.');
    }

    public function show(Exam $exam)
    {
        $exam->load(['academicYear', 'examRoutines' => function($q) {
            $q->with(['class', 'section', 'subject']);
        }]);
        
        return view('admin.exams.show', compact('exam'));
    }

    public function edit(Exam $exam)
    {
        $academicYears = AcademicYear::where('status', 'active')->get();
        return view('admin.exams.edit', compact('exam', 'academicYears'));
    }

    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'term' => 'required|in:first_term,second_term,third_term,final',
            'academic_year_id' => 'required|exists:academic_years,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        $exam->update($request->all());

        return redirect()->route('admin.exams.index')
            ->with('success', 'Exam updated successfully.');
    }

    public function destroy(Exam $exam)
    {
        $exam->examRoutines()->delete();
        $exam->examResults()->delete();
        $exam->delete();

        return redirect()->route('admin.exams.index')
            ->with('success', 'Exam deleted successfully.');
    }

    // Exam Routine Methods
    public function routine(Exam $exam)
    {
        $classes = Classes::all();
        $subjects = Subject::all();
        return view('admin.exams.routine', compact('exam', 'classes', 'subjects'));
    }

    public function routineStore(Request $request, Exam $exam)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'full_marks' => 'required|integer|min:1',
            'pass_marks' => 'required|integer|min:0',
        ]);

        ExamRoutine::create([
            'exam_id' => $exam->id,
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
            'subject_id' => $request->subject_id,
            'exam_date' => $request->exam_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'full_marks' => $request->full_marks,
            'pass_marks' => $request->pass_marks,
            'room_no' => $request->room_no,
        ]);

        return redirect()->back()->with('success', 'Exam routine added successfully.');
    }

    // Marks Entry Methods
    public function marksEntry(Exam $exam)
    {
        $classes = Classes::all();
        return view('admin.exams.marks-entry', compact('exam', 'classes'));
    }

    public function getStudents(Request $request)
    {
        $students = Student::where('class_id', $request->class_id)
                          ->where('section_id', $request->section_id)
                          ->with(['class', 'section'])
                          ->get();
        
        $subjects = Subject::whereHas('classes', function($q) use ($request) {
            $q->where('class_id', $request->class_id);
        })->get();
        
        return response()->json([
            'students' => $students,
            'subjects' => $subjects
        ]);
    }

    public function marksStore(Request $request, Exam $exam)
    {
        foreach ($request->marks as $studentId => $subjects) {
            foreach ($subjects as $subjectId => $marks) {
                $theoryMarks = $marks['theory'] ?? 0;
                $practicalMarks = $marks['practical'] ?? 0;
                $totalMarks = $theoryMarks + $practicalMarks;
                
                $subject = Subject::find($subjectId);
                $percentage = ($totalMarks / ($subject->theory_marks + $subject->practical_marks)) * 100;
                $grade = ExamResult::calculateGrade($percentage);
                
                ExamResult::updateOrCreate(
                    [
                        'exam_id' => $exam->id,
                        'student_id' => $studentId,
                        'subject_id' => $subjectId,
                    ],
                    [
                        'theory_marks' => $theoryMarks,
                        'practical_marks' => $practicalMarks,
                        'total_marks' => $totalMarks,
                        'grade' => $grade,
                        'remarks' => $marks['remarks'] ?? null,
                    ]
                );
            }
        }
        
        return redirect()->back()->with('success', 'Marks saved successfully.');
    }
}