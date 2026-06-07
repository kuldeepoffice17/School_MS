@extends('layouts.admin')

@section('title', 'Section Details - ' . $section->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <!-- Section Info Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-layers"></i> Section Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted mb-1">Section Name</label>
                        <p><strong>{{ $section->name }}</strong></p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted mb-1">Class</label>
                        <p><strong>{{ $section->class->name }} ({{ $section->class->numeric_name }})</strong></p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted mb-1">Capacity</label>
                        <p><strong>{{ $section->capacity }} students</strong></p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted mb-1">Current Enrollment</label>
                        <p><strong>{{ $totalStudents }} students</strong></p>
                        <div class="progress">
                            @php $percentage = ($totalStudents / $section->capacity) * 100; @endphp
                            <div class="progress-bar bg-{{ $percentage >= 90 ? 'danger' : ($percentage >= 70 ? 'warning' : 'success') }}" 
                                 style="width: {{ $percentage }}%">
                                {{ round($percentage) }}%
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted mb-1">Available Seats</label>
                        <p><strong>{{ $section->capacity - $totalStudents }} seats left</strong></p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <!-- Students List -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-people"></i> Students in this Section
                    </h6>
                </div>
                <div class="card-body">
                    @if($section->students->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Admission No</th>
                                        <th>Roll No</th>
                                        <th>Student Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($section->students as $student)
                                    <tr>
                                        <td>{{ $student->admission_no }}</td>
                                        <td>{{ $student->roll_no ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('admin.students.show', $student) }}">
                                                {{ $student->first_name }} {{ $student->last_name }}
                                            </a>
                                        </td>
                                        <td>{{ $student->email }}</td>
                                        <td>{{ $student->phone }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <p class="text-muted mt-2">No students enrolled in this section yet.</p>
                            <a href="{{ route('admin.students.create') }}?section_id={{ $section->id }}" 
                               class="btn btn-primary btn-sm">
                                Add Student
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="card shadow">
                <div class="card-body">
                    <a href="{{ route('admin.sections.edit', $section) }}" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Edit Section
                    </a>
                    <a href="{{ route('admin.sections.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection