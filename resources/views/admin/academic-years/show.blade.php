@extends('layouts.admin')

@section('title', 'Class Details - ' . $class->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <!-- Class Info Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-building"></i> Class Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted mb-1">Class Name</label>
                        <p><strong>{{ $class->name }}</strong></p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted mb-1">Numeric Name</label>
                        <p><strong>{{ $class->numeric_name }}</strong></p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted mb-1">Description</label>
                        <p>{{ $class->description ?? 'No description' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted mb-1">Created At</label>
                        <p>{{ $class->created_at ? $class->created_at->format('d M Y, h:i A') : 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1">Total Sections</p>
                                <h3 class="mb-0">{{ $class->sections->count() }}</h3>
                            </div>
                            <div class="bg-info bg-opacity-10 p-3 rounded">
                                <i class="bi bi-layers fs-1 text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-3">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1">Total Students</p>
                                <h3 class="mb-0">{{ $class->students->count() }}</h3>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                <i class="bi bi-people fs-1 text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sections List -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-layers"></i> Sections in this Class
                    </h6>
                    <a href="{{ route('admin.sections.create') }}?class_id={{ $class->id }}" 
                       class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle"></i> Add Section
                    </a>
                </div>
                <div class="card-body">
                    @if($class->sections->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Section Name</th>
                                        <th>Capacity</th>
                                        <th>Students Enrolled</th>
                                        <th>Available Seats</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($class->sections as $section)
                                    <tr>
                                        <td>{{ $section->name }}</td>
                                        <td>{{ $section->capacity }}</td>
                                        <td>{{ $section->students->count() }}</td>
                                        <td>
                                            @php $available = $section->capacity - $section->students->count(); @endphp
                                            @if($available > 0)
                                                <span class="badge bg-success">{{ $available }} seats</span>
                                            @else
                                                <span class="badge bg-danger">Full</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($available > 0)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-warning">Full</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <p class="text-muted mt-2">No sections added yet.</p>
                            <a href="{{ route('admin.sections.create') }}?class_id={{ $class->id }}" 
                               class="btn btn-primary btn-sm">
                                Add Section
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="card shadow">
                <div class="card-body">
                    <a href="{{ route('admin.classes.edit', $class) }}" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Edit Class
                    </a>
                    <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection