@extends('layouts.admin')

@section('title', 'Exam Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Exam Information</h6>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $exam->name }}</p>
                    <p><strong>Term:</strong> {{ ucfirst(str_replace('_', ' ', $exam->term)) }}</p>
                    <p><strong>Academic Year:</strong> {{ $exam->academicYear->name ?? 'N/A' }}</p>
                    <p><strong>Start Date:</strong> {{ date('d M Y', strtotime($exam->start_date)) }}</p>
                    <p><strong>End Date:</strong> {{ date('d M Y', strtotime($exam->end_date)) }}</p>
                    <p><strong>Status:</strong> 
                        <span class="badge bg-{{ $exam->exam_status == 'upcoming' ? 'info' : ($exam->exam_status == 'ongoing' ? 'warning' : 'success') }}">
                            {{ ucfirst($exam->exam_status) }}
                        </span>
                    </p>
                    <p><strong>Description:</strong> {{ $exam->description ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Exam Routine</h6>
                </div>
                <div class="card-body">
                    @if($exam->examRoutines->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr><th>Date</th><th>Class</th><th>Subject</th><th>Time</th><th>Room</th><th>Marks</th></tr>
                                </thead>
                                <tbody>
                                    @foreach($exam->examRoutines as $routine)
                                    <tr>
                                        <td>{{ date('d M Y', strtotime($routine->exam_date)) }}</td>
                                        <td>{{ $routine->class->name }} - {{ $routine->section->name }}</td>
                                        <td>{{ $routine->subject->name }}</td>
                                        <td>{{ date('h:i A', strtotime($routine->start_time)) }} - {{ date('h:i A', strtotime($routine->end_time)) }}</td>
                                        <td>{{ $routine->room_no ?? 'N/A' }}</td>
                                        <td>{{ $routine->full_marks }} (Pass: {{ $routine->pass_marks }})</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No routine added yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection