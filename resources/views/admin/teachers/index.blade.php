@extends('layouts.admin')

@section('title', 'Teacher Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-person-badge"></i> Teacher Management
                    </h6>
                    <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle"></i> Add New Teacher
                    </a>
                </div>
                <div class="card-body">
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('admin.teachers.index') }}" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Search by name, teacher ID, email..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-control">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="on_leave" {{ request('status') == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="gender" class="form-control">
                                    <option value="">All Genders</option>
                                    <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-search"></i> Filter
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Teachers Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Teacher ID</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Qualification</th>
                                    <th>Specialization</th>
                                    <th>Assigned Classes</th>
                                    <th>Status</th>
                                    <th>Joining Date</th>
                                    <th width="120">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($teachers as $teacher)
                                <tr>
                                    <td>{{ $teacher->teacher_id }}</td>
                                    <td>
                                        @if($teacher->photo)
                                            <img src="{{ Storage::url($teacher->photo) }}" width="40" height="40" class="rounded-circle">
                                        @else
                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <span class="text-white">{{ strtoupper(substr($teacher->first_name, 0, 1)) }}</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $teacher->first_name }} {{ $teacher->last_name }}</strong>
                                    </td>
                                    <td>{{ $teacher->email }}</td>
                                    <td>{{ $teacher->phone }}</td>
                                    <td>{{ $teacher->qualification }}</td>
                                    <td>{{ $teacher->specialization }}</td>
                                    <td>
                                        @foreach($teacher->classes as $class)
                                            <span class="badge bg-info m-1">{{ $class->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if($teacher->status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @elseif($teacher->status == 'inactive')
                                            <span class="badge bg-danger">Inactive</span>
                                        @else
                                            <span class="badge bg-warning">On Leave</span>
                                        @endif
                                    </td>
                                    <td>{{ $teacher->joining_date ? date('d M Y', strtotime($teacher->joining_date)) : 'N/A' }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.teachers.show', $teacher) }}" class="btn btn-info" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.teachers.edit', $teacher) }}" class="btn btn-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="{{ route('admin.teachers.assign-class', $teacher) }}" class="btn btn-warning btn-sm" title="Assign Class">
                                                <i class="bi bi-person-plus"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger delete-teacher" 
                                                    data-id="{{ $teacher->id }}" data-name="{{ $teacher->first_name }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                            <form id="delete-form-{{ $teacher->id }}" 
                                                  action="{{ route('admin.teachers.destroy', $teacher) }}" 
                                                  method="POST" style="display: none;">
                                                @csrf @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="10" class="text-center">No teachers found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $teachers->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.delete-teacher').click(function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "Delete this teacher?",
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