<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\FeeController;
use App\Http\Controllers\HomeController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Auth routes (login, register, etc.)
Auth::routes();

// Home route after login
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Admin Routes - Protected with auth and role middleware
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Student Management
    Route::resource('students', StudentController::class);
    Route::get('get-sections/{classId}', [StudentController::class, 'getSections'])->name('get.sections');
    
    // Teacher Management
    Route::resource('teachers', TeacherController::class);
    
    // Class Management
    Route::resource('classes', ClassController::class);
    Route::get('class-sections/{classId}', [ClassController::class, 'getSections'])->name('class.sections');
    
    // Subject Management
    Route::resource('subjects', SubjectController::class);
    
    // Exam Management
    Route::resource('exams', ExamController::class);
    
    // Attendance Management
    Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('attendance/mark', [AttendanceController::class, 'markAttendance'])->name('attendance.mark');
    Route::get('attendance/report', [AttendanceController::class, 'report'])->name('attendance.report');
    
    // Fee Management
    Route::resource('fees', FeeController::class);
    Route::post('fees/{fee}/payment', [FeeController::class, 'addPayment'])->name('fees.payment');
    Route::get('fee-collection', [FeeController::class, 'collectionReport'])->name('fees.collection');
});