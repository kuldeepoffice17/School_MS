<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Redirect based on user role
        if (auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->hasRole('teacher')) {
            return redirect()->route('teacher.dashboard');
        } elseif (auth()->user()->hasRole('student')) {
            return redirect()->route('student.dashboard');
        } else {
            return view('home');
        }
    }

    public function indexhome()
    {
        // Ye data dynamic bana sakte ho database se
        $notices = [
            'School will remain closed on 26th Jan',
            'PTM on 30th Jan 2026',
            'Annual Exam starts from 10th March'
        ];

        $upcomingEvents = [
            ['name' => 'Sports Day', 'date' => '15 Feb 2026'],
            ['name' => 'Science Exhibition', 'date' => '20 Feb 2026'],
        ];

        return view('indexhome', compact('notices', 'upcomingEvents'));
    }

}