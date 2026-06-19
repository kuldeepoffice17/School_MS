@extends('layouts.admin')

@section('title', 'Add Grade')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Add Grade</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.grades.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Grade Name *</label>
                                    <input type="text" name="name" class="form-control" placeholder="e.g., A+, A, B+" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Grade Point *</label>
                                    <input type="number" step="0.01" name="grade_point" class="form-control" placeholder="e.g., 4.0, 3.5" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Min Percentage *</label>
                                    <input type="number" name="min_percentage" class="form-control" placeholder="e.g., 90" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Max Percentage *</label>
                                    <input type="number" name="max_percentage" class="form-control" placeholder="e.g., 100" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label>Remark</label>
                                    <textarea name="remark" class="form-control" rows="2" placeholder="e.g., Outstanding"></textarea>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Grade</button>
                        <a href="{{ route('admin.grades.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection