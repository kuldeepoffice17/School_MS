@extends('layouts.admin')

@section('title', 'Student Details - ' . $student->full_name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <!-- Profile Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profile Information</h6>
                </div>
                <div class="card-body text-center">
                    @if($student->photo)
                        <img src="{{ Storage::url($student->photo) }}" alt="{{ $student->full_name }}" class="rounded-circle img-fluid mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="mx-auto bg-primary rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 150px; height: 150px;">
                            <span class="text-white" style="font-size: 48px;">
                                {{ strtoupper(substr($student->first_name, 0, 1)) }}{{ strtoupper(substr($student->last_name, 0, 1)) }}
                            </span>
                        </div>
                    @endif
                    
                    <h4 class="mb-1">{{ $student->full_name }}</h4>
                    <p class="text-muted">Admission No: {{ $student->admission_no }}</p>
                    
                    <div class="mt-3">
                        <span class="badge bg-{{ $student->status == 'active' ? 'success' : 'danger' }} px-3 py-2">
                            {{ ucfirst($student->status) }}
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Contact Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Contact Information</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted mb-1">Email</label>
                        <p class="mb-0"><i class="bi bi-envelope"></i> {{ $student->email }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted mb-1">Phone</label>
                        <p class="mb-0"><i class="bi bi-telephone"></i> {{ $student->phone }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted mb-1">Address</label>
                        <p class="mb-0"><i class="bi bi-geo-alt"></i> {{ $student->address }}</p>
                        @if($student->city || $student->state)
                            <p class="mb-0">{{ $student->city }}, {{ $student->state }} - {{ $student->pincode }}</p>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Parent Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Parent Information</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted mb-1">Parent/Guardian Name</label>
                        <p class="mb-0"><i class="bi bi-person"></i> {{ $student->parent_name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted mb-1">Parent Phone</label>
                        <p class="mb-0"><i class="bi bi-telephone"></i> {{ $student->parent_phone }}</p>
                    </div>
                    @if($student->parent_email)
                    <div class="mb-3">
                        <label class="text-muted mb-1">Parent Email</label>
                        <p class="mb-0"><i class="bi bi-envelope"></i> {{ $student->parent_email }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <!-- Academic Info Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Academic Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted mb-1">Roll Number</label>
                                <p><strong>{{ $student->roll_no ?? 'Not assigned' }}</strong></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted mb-1">Class - Section</label>
                                <p><strong>{{ $student->class->name ?? 'N/A' }} - {{ $student->section->name ?? 'N/A' }}</strong></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted mb-1">Date of Birth</label>
                                <p><strong>{{ $student->date_of_birth ? $student->date_of_birth->format('d M Y') : 'N/A' }}</strong></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted mb-1">Gender</label>
                                <p><strong>{{ ucfirst($student->gender) }}</strong></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted mb-1">Blood Group</label>
                                <p><strong>{{ $student->blood_group ?? 'N/A' }}</strong></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted mb-1">Admission Date</label>
                                <p><strong>{{ $student->admission_date ? $student->admission_date->format('d M Y') : 'N/A' }}</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Attendance -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Attendance</h6>
                </div>
                <div class="card-body">
                    @if($student->attendances->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr><th>Date</th><th>Status</th><th>Remark</th></tr>
                                </thead>
                                <tbody>
                                    @foreach($student->attendances as $attendance)
                                    <tr>
                                        <td>{{ $attendance->date->format('d M Y') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $attendance->status == 'present' ? 'success' : ($attendance->status == 'absent' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($attendance->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $attendance->remark ?? '-' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No attendance records found.</p>
                    @endif
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="card shadow">
                <div class="card-body">
                    <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Edit Student
                    </a>
                    <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to List
                    </a>
                    <form action="{{ route('admin.students.destroy', $student) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger delete-btn">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection