@extends('layouts.admin')

@section('title', 'Add Academic Year')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-calendar-plus"></i> Add New Academic Year
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.academic-years.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label>Academic Year Name *</label>
                                    <input type="text" name="name" class="form-control" 
                                           placeholder="e.g., 2024-2025, 2025-2026" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Start Date *</label>
                                    <input type="date" name="start_date" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>End Date *</label>
                                    <input type="date" name="end_date" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input type="checkbox" name="is_current" value="1" class="form-check-input" id="is_current">
                                    <label class="form-check-label" for="is_current">Set as Current Academic Year</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">Save Academic Year</button>
                            <a href="{{ route('admin.academic-years.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection