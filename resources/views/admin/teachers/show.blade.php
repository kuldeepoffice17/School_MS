@extends('layouts.admin')

@section('title', 'Teacher Details - ' . $teacher->first_name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profile</h6>
                </div>
                <div class="card-body text-center">
                    @if($teacher->photo)
                        <img src="{{ Storage::url($teacher->photo) }}" class="rounded-circle mb-3" width="150" height="150">
                    @else
                        <div class="bg-primary rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 150px; height: 150px;">
                            <span class="text-white" style="font-size: 48px;">{{ strtoupper(substr($teacher->first_name, 0, 1)) }}{{ strtoupper(substr($teacher->last_name, 0, 1)) }}</span>
                        </div>
                    @endif
                    <h4>{{ $teacher->first_name }} {{ $teacher->last_name }}</h4>
                    <p class="text-muted">ID: {{ $teacher->teacher_id }}</p>
                    <span class="badge bg-{{ $teacher->status == 'active' ? 'success' : ($teacher->status == 'inactive' ? 'danger' : 'warning') }} px-3 py-2">{{ ucfirst($teacher->status) }}</span>
                </div>
            </div>
            
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Contact</h6>
                </div>
                <div class="card-body">
                    <p><i class="bi bi-envelope"></i> {{ $teacher->email }}</p>
                    <p><i class="bi bi-telephone"></i> {{ $teacher->phone }}</p>
                    <p><i class="bi bi-geo-alt"></i> {{ $teacher->address }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Professional Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="text-muted">Qualification</label>
                            <p><strong>{{ $teacher->qualification }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted">Specialization</label>
                            <p><strong>{{ $teacher->specialization }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted">Date of Birth</label>
                            <p><strong>{{ date('d M Y', strtotime($teacher->dob)) }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted">Joining Date</label>
                            <p><strong>{{ date('d M Y', strtotime($teacher->joining_date)) }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted">Gender</label>
                            <p><strong>{{ ucfirst($teacher->gender) }}</strong></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Assigned Classes</h6>
                </div>
                <div class="card-body">
                    @if($teacher->classes->count() > 0)
                        @foreach($teacher->classes as $class)
                            <span class="badge bg-primary m-1 p-2">{{ $class->name }} ({{ $class->numeric_name }})</span>
                        @endforeach
                    @else
                        <p class="text-muted">No classes assigned yet.</p>
                    @endif
                </div>
            </div>
            
            <div class="card shadow">
                <div class="card-body">
                    <a href="{{ route('admin.teachers.edit', $teacher) }}" class="btn btn-primary">Edit Teacher</a>
                    <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection