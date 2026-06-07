@extends('layouts.admin')

@section('title', 'Assign Subject to Class')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-journal-bookmark-fill"></i> Assign Subjects to Class: {{ $class->name }} ({{ $class->numeric_name }})
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.classes.assign-subject-store', $class) }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label>Select Subjects</label>
                                    <select name="subjects[]" class="form-control" multiple required size="10">
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}" {{ $class->subjects->contains($subject->id) ? 'selected' : '' }}>
                                                {{ $subject->name }} ({{ $subject->code }}) - {{ ucfirst($subject->type) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Hold Ctrl to select multiple subjects</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">Save Assignment</button>
                            <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection