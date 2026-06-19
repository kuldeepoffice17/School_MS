<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Classes;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Display attendance marking page
     */
    public function index(Request $request)
    {
        $classes = Classes::all();
        $selectedClass = null;
        $selectedSection = null;
        $students = collect();
        $attendanceData = [];
        $date = $request->date ?? date('Y-m-d');

        if ($request->has('class_id') && $request->class_id != '') {
            $selectedClass = Classes::with('sections')->find($request->class_id);
            
            if ($request->has('section_id') && $request->section_id != '') {
                $selectedSection = Section::find($request->section_id);
                
                // Get students for this class and section
                $students = Student::where('class_id', $request->class_id)
                    ->where('section_id', $request->section_id)
                    ->where('status', 'active')
                    ->orderBy('roll_no')
                    ->get();
                
                // Get existing attendance for this date
                $attendanceData = Attendance::where('class_id', $request->class_id)
                    ->where('section_id', $request->section_id)
                    ->where('date', $date)
                    ->get()
                    ->keyBy('student_id');
            }
        }

        return view('admin.attendance.index', compact(
            'classes', 'selectedClass', 'selectedSection', 
            'students', 'attendanceData', 'date'
        ));
    }

    /**
     * Mark attendance for students
     */
    public function markAttendance(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*.status' => 'required|in:present,absent,late,half_day',
        ]);

        $classId = $request->class_id;
        $sectionId = $request->section_id;
        $date = $request->date;

        foreach ($request->attendance as $studentId => $data) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'class_id' => $classId,
                    'section_id' => $sectionId,
                    'date' => $date,
                ],
                [
                    'status' => $data['status'],
                    'remarks' => $data['remarks'] ?? null,
                ]
            );
        }

        return redirect()->route('admin.attendance.index', [
            'class_id' => $classId,
            'section_id' => $sectionId,
            'date' => $date
        ])->with('success', 'Attendance marked successfully.');
    }

    /**
     * Display attendance report
     */
    public function report(Request $request)
    {
        $classes = Classes::all();
        $reportData = [];
        $summary = [];

        if ($request->has('class_id') && $request->class_id != '') {
            $classId = $request->class_id;
            $sectionId = $request->section_id;
            $month = $request->month ?? date('Y-m');
            $startDate = date('Y-m-01', strtotime($month . '-01'));
            $endDate = date('Y-m-t', strtotime($month . '-01'));

            $query = Attendance::with('student')
                ->where('class_id', $classId)
                ->whereBetween('date', [$startDate, $endDate]);

            if ($sectionId) {
                $query->where('section_id', $sectionId);
            }

            $attendances = $query->get()->groupBy('student_id');

            $students = Student::where('class_id', $classId)
                ->when($sectionId, function($q) use ($sectionId) {
                    return $q->where('section_id', $sectionId);
                })
                ->where('status', 'active')
                ->orderBy('roll_no')
                ->get();

            foreach ($students as $student) {
                $studentAttendances = $attendances->get($student->id, collect());
                $totalDays = $studentAttendances->count();
                $present = $studentAttendances->where('status', 'present')->count();
                $absent = $studentAttendances->where('status', 'absent')->count();
                $late = $studentAttendances->where('status', 'late')->count();
                $halfDay = $studentAttendances->where('status', 'half_day')->count();
                
                $percentage = $totalDays > 0 ? round(($present / $totalDays) * 100, 2) : 0;

                $reportData[] = [
                    'student' => $student,
                    'total_days' => $totalDays,
                    'present' => $present,
                    'absent' => $absent,
                    'late' => $late,
                    'half_day' => $halfDay,
                    'percentage' => $percentage,
                ];
            }

            $summary = [
                'total_students' => $students->count(),
                'total_present' => collect($reportData)->sum('present'),
                'total_absent' => collect($reportData)->sum('absent'),
                'total_late' => collect($reportData)->sum('late'),
                'total_half_day' => collect($reportData)->sum('half_day'),
                'overall_percentage' => $students->count() > 0 ? 
                    round(collect($reportData)->avg('percentage'), 2) : 0,
            ];
        }

        return view('admin.attendance.report', compact(
            'classes', 'reportData', 'summary', 'request'
        ));
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