@extends('layouts.admin')

@section('title', 'Edit Grade - ' . $grade->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-pencil-square"></i> Edit Grade
                    </h6>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.grades.update', $grade) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Grade Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $grade->name) }}" 
                                           placeholder="e.g., A+, A, B+" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="grade_point" class="form-label">Grade Point <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control @error('grade_point') is-invalid @enderror" 
                                           id="grade_point" name="grade_point" value="{{ old('grade_point', $grade->grade_point) }}" 
                                           placeholder="e.g., 4.0, 3.5" required>
                                    @error('grade_point')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="min_percentage" class="form-label">Min Percentage <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('min_percentage') is-invalid @enderror" 
                                           id="min_percentage" name="min_percentage" value="{{ old('min_percentage', $grade->min_percentage) }}" 
                                           placeholder="e.g., 90" required>
                                    @error('min_percentage')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="max_percentage" class="form-label">Max Percentage <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('max_percentage') is-invalid @enderror" 
                                           id="max_percentage" name="max_percentage" value="{{ old('max_percentage', $grade->max_percentage) }}" 
                                           placeholder="e.g., 100" required>
                                    @error('max_percentage')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="remark" class="form-label">Remark</label>
                                    <textarea class="form-control @error('remark') is-invalid @enderror" 
                                              id="remark" name="remark" rows="2" 
                                              placeholder="e.g., Outstanding, Excellent, Good">{{ old('remark', $grade->remark) }}</textarea>
                                    @error('remark')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-check mb-3">
                                    <input type="checkbox" class="form-check-input" id="is_active" 
                                           name="is_active" value="1" {{ old('is_active', $grade->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Update Grade
                            </button>
                            <a href="{{ route('admin.grades.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection