@extends('layouts.admin')

@section('title', 'Subject Details - ' . $subject->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Subject Information</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted">Subject Code</label>
                        <p><strong>{{ $subject->code }}</strong></p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Subject Name</label>
                        <p><strong>{{ $subject->name }}</strong></p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Type</label>
                        <p>
                            @if($subject->type == 'theory')
                                <span class="badge bg-info">Theory Only</span>
                            @elseif($subject->type == 'practical')
                                <span class="badge bg-warning">Practical Only</span>
                            @else
                                <span class="badge bg-success">Both Theory & Practical</span>
                            @endif
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Theory Marks</label>
                        <p><strong>{{ $subject->theory_marks }}</strong></p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Practical Marks</label>
                        <p><strong>{{ $subject->practical_marks }}</strong></p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Total Marks</label>
                        <p><strong class="text-success">{{ $subject->theory_marks + $subject->practical_marks }}</strong></p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Assigned Classes</h6>
                </div>
                <div class="card-body">
                    @if($subject->classes->count() > 0)
                        @foreach($subject->classes as $class)
                            <span class="badge bg-primary m-1 p-2">{{ $class->name }} ({{ $class->numeric_name }})</span>
                        @endforeach
                    @else
                        <p class="text-muted">No classes assigned yet.</p>
                    @endif
                </div>
            </div>
            
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Assigned Teachers</h6>
                </div>
                <div class="card-body">
                    @if($subject->teachers->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr><th>Name</th><th>Qualification</th><th>Specialization</th></tr>
                                </thead>
                                <tbody>
                                    @foreach($subject->teachers as $teacher)
                                    <tr>
                                        <td>{{ $teacher->first_name }} {{ $teacher->last_name }}</td>
                                        <td>{{ $teacher->qualification }}</td>
                                        <td>{{ $teacher->specialization }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No teachers assigned yet.</p>
                    @endif
                </div>
            </div>
            
            <div class="card shadow">
                <div class="card-body">
                    <a href="{{ route('admin.subjects.edit', $subject) }}" class="btn btn-primary">Edit Subject</a>
                    <a href="{{ route('admin.subjects.index') }}" class="btn btn-secondary">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection