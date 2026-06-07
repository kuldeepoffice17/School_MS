@extends('layouts.admin')

@section('title', 'Assign Class to Teacher')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-person-plus"></i> Assign Class to Teacher: {{ $teacher->first_name }} {{ $teacher->last_name }}
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.teachers.assign-class-store', $teacher) }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label>Select Classes</label>
                                    <select name="classes[]" class="form-control" multiple required size="10">
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}" {{ $teacher->classes->contains($class->id) ? 'selected' : '' }}>
                                                {{ $class->name }} ({{ $class->numeric_name }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Hold Ctrl to select multiple classes</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">Save Assignment</button>
                            <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection