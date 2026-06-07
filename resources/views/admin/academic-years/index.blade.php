@extends('layouts.admin')

@section('title', 'Academic Year Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-calendar"></i> Academic Year Management
                    </h6>
                    <a href="{{ route('admin.academic-years.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle"></i> Add New Academic Year
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Exams Count</th>
                                    <th width="150">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($academicYears as $year)
                                <tr>
                                    <td>
                                        <strong>{{ $year->name }}</strong>
                                        @if($year->is_current)
                                            <span class="badge bg-success ms-2">Current</span>
                                        @endif
                                    </td>
                                    <td>{{ date('d M Y', strtotime($year->start_date)) }}</td>
                                    <td>{{ date('d M Y', strtotime($year->end_date)) }}</td>
                                    <td>
                                        @if($year->is_current)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $year->exams->count() }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            @if(!$year->is_current)
                                                <a href="{{ route('admin.academic-years.set-current', $year) }}" 
                                                   class="btn btn-success" title="Set as Current">
                                                    <i class="bi bi-star"></i>
                                                </a>
                                            @endif
                                            <a href="{{ route('admin.academic-years.edit', $year) }}" 
                                               class="btn btn-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger delete-year" 
                                                    data-id="{{ $year->id }}" data-name="{{ $year->name }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                            <form id="delete-form-{{ $year->id }}" 
                                                  action="{{ route('admin.academic-years.destroy', $year) }}" 
                                                  method="POST" style="display: none;">
                                                @csrf @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="text-center">No academic years found. <a href="{{ route('admin.academic-years.create') }}">Create one</a></td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $academicYears->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.delete-year').click(function() {
        let id = $(this).data('id');
        let name = $(this).data('name');
        Swal.fire({
            title: 'Are you sure?',
            text: "Delete academic year: " + name + "?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, delete!'
        }).then((result) => {
            if (result.isConfirmed) document.getElementById('delete-form-' + id).submit();
        });
    });
});
</script>
@endpush