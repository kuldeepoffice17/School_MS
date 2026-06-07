@extends('layouts.admin')

@section('title', 'Class Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-building"></i> Class Management
                    </h6>
                    <a href="{{ route('admin.classes.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle"></i> Add New Class
                    </a>
                </div>
                <div class="card-body">
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('admin.classes.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Search by class name or numeric name..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-search"></i> Search
                                </button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary w-100">
                                    <i class="bi bi-arrow-repeat"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Classes Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Class Name</th>
                                    <th>Numeric Name</th>
                                    <th>Description</th>
                                    <th>Sections</th>
                                    <th>Total Students</th>
                                    <th>Created At</th>
                                    <th width="120">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($classes as $class)
                                <tr>
                                    <td>{{ $class->id }}</td>
                                    <td><strong>{{ $class->name }}</strong></td>
                                    <td>{{ $class->numeric_name }}</td>
                                    <td>{{ Str::limit($class->description, 50) ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $class->sections->count() }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">{{ $class->students->count() }}</span>
                                    </td>
                                    <td>{{ $class->created_at ? $class->created_at->format('d M Y') : 'N/A' }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.classes.show', $class) }}" 
                                               class="btn btn-info" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.classes.edit', $class) }}" 
                                               class="btn btn-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="{{ route('admin.classes.assign-subject', $class) }}" class="btn btn-warning btn-sm" title="Assign Subjects">
                                                <i class="bi bi-journal-bookmark"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-danger delete-class" 
                                                    data-id="{{ $class->id }}"
                                                    data-name="{{ $class->name }}"
                                                    title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                            <form id="delete-form-{{ $class->id }}" 
                                                  action="{{ route('admin.classes.destroy', $class) }}" 
                                                  method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">No classes found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $classes->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // SweetAlert delete confirmation
        $('.delete-class').click(function(e) {
            e.preventDefault();
            let classId = $(this).data('id');
            let className = $(this).data('name');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete class: " + className + "?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + classId).submit();
                }
            });
        });
    });
</script>
@endpush