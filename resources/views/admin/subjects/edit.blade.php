@extends('layouts.admin')

@section('title', 'Edit Subject - ' . $subject->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-pencil-square"></i> Edit Subject
                    </h6>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.subjects.update', $subject) }}" method="POST">
                        @csrf @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Subject Name *</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $subject->name) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Subject Code *</label>
                                    <input type="text" name="code" class="form-control" value="{{ old('code', $subject->code) }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Subject Type *</label>
                                    <select name="type" class="form-control" required>
                                        <option value="theory" {{ $subject->type == 'theory' ? 'selected' : '' }}>Theory Only</option>
                                        <option value="practical" {{ $subject->type == 'practical' ? 'selected' : '' }}>Practical Only</option>
                                        <option value="both" {{ $subject->type == 'both' ? 'selected' : '' }}>Both</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Theory Marks *</label>
                                    <input type="number" name="theory_marks" class="form-control" value="{{ old('theory_marks', $subject->theory_marks) }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Practical Marks *</label>
                                    <input type="number" name="practical_marks" class="form-control" value="{{ old('practical_marks', $subject->practical_marks) }}" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Assign to Classes</label>
                                    <select name="classes[]" class="form-control" multiple size="5">
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}" {{ $subject->classes->contains($class->id) ? 'selected' : '' }}>
                                                {{ $class->name }} ({{ $class->numeric_name }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Assign to Teachers</label>
                                    <select name="teachers[]" class="form-control" multiple size="5">
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher->id }}" {{ $subject->teachers->contains($teacher->id) ? 'selected' : '' }}>
                                                {{ $teacher->first_name }} {{ $teacher->last_name }} - {{ $teacher->specialization }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update Subject</button>
                            <a href="{{ route('admin.subjects.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection