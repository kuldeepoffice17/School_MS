<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\AcademicYearController;
use App\Http\Controllers\Admin\FeeController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\GradeController;
use App\Http\Controllers\HomeController;

// Public routes
// Route::get('/', function () {
//     return view('welcome');
// });

// Auth routes (login, register, etc.)
Auth::routes();

// Home route after login
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/', [HomeController::class, 'indexhome'])->name('homeindex');

// Admin Routes - Protected with auth and role middleware
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Student Management
    Route::resource('students', StudentController::class);
    Route::get('get-sections/{classId}', [StudentController::class, 'getSections'])->name('get.sections');
    
    // Teacher Management
    Route::resource('teachers', TeacherController::class);
    Route::get('teachers/{teacher}/assign-class', [TeacherController::class, 'assignClass'])->name('teachers.assign-class');
   Route::post('teachers/{teacher}/assign-class', [TeacherController::class, 'assignClassStore'])->name('teachers.assign-class-store');
    // Class Management
    Route::resource('classes', ClassController::class);
    Route::get('class-sections/{classId}', [ClassController::class, 'getSections'])->name('class.sections');
    Route::get('classes/{class}/assign-subject', [ClassController::class, 'assignSubject'])->name('classes.assign-subject');
    Route::post('classes/{class}/assign-subject', [ClassController::class, 'assignSubjectStore'])->name('classes.assign-subject-store');
    // Subject Management
    Route::resource('subjects', SubjectController::class);
    
    // Exam Management
    Route::resource('exams', ExamController::class);
    Route::get('exams/{exam}/routine', [ExamController::class, 'routine'])->name('exams.routine');
    Route::post('exams/{exam}/routine', [ExamController::class, 'routineStore'])->name('exams.routine-store');
    Route::get('exams/{exam}/marks-entry', [ExamController::class, 'marksEntry'])->name('exams.marks-entry');
    Route::post('exams/{exam}/marks', [ExamController::class, 'marksStore'])->name('exams.marks-store');
    Route::get('get-students', [ExamController::class, 'getStudents'])->name('exams.get-students');
    
    // Attendance Management
    Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('attendance/mark', [AttendanceController::class, 'markAttendance'])->name('attendance.mark');
    Route::get('attendance/report', [AttendanceController::class, 'report'])->name('attendance.report');
    
        // Academic Year Management
    Route::resource('academic-years', AcademicYearController::class);
    Route::post('academic-years/{academicYear}/set-current', [AcademicYearController::class, 'setCurrent'])->name('academic-years.set-current');
    // Fee Management
    Route::resource('fees', FeeController::class);
    Route::post('fees/{fee}/payment', [FeeController::class, 'addPayment'])->name('fees.payment');
    Route::get('fee-collection', [FeeController::class, 'collectionReport'])->name('fees.collection');

    // Settings Routes
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('settings/general', [SettingController::class, 'general'])->name('settings.general');
    Route::put('settings/general', [SettingController::class, 'updateGeneral'])->name('settings.update-general');
    Route::put('settings/logo', [SettingController::class, 'updateLogo'])->name('settings.update-logo');

    // Grade Management Routes
    Route::resource('grades', GradeController::class);
});