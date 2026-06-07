@extends('layouts.admin')

@section('title', 'Subject Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-book"></i> Subject Management
                    </h6>
                    <a href="{{ route('admin.subjects.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle"></i> Add New Subject
                    </a>
                </div>
                <div class="card-body">
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('admin.subjects.index') }}" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Search by name or code..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="type" class="form-control">
                                    <option value="">All Types</option>
                                    <option value="theory" {{ request('type') == 'theory' ? 'selected' : '' }}>Theory</option>
                                    <option value="practical" {{ request('type') == 'practical' ? 'selected' : '' }}>Practical</option>
                                    <option value="both" {{ request('type') == 'both' ? 'selected' : '' }}>Both</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-search"></i> Filter
                                </button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('admin.subjects.index') }}" class="btn btn-secondary w-100">
                                    <i class="bi bi-arrow-repeat"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Subjects Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Code</th>
                                    <th>Subject Name</th>
                                    <th>Type</th>
                                    <th>Theory Marks</th>
                                    <th>Practical Marks</th>
                                    <th>Total Marks</th>
                                    <th>Assigned Classes</th>
                                    <th>Assigned Teachers</th>
                                    <th width="120">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subjects as $subject)
                                <tr>
                                    <td><strong>{{ $subject->code }}</strong></td>
                                    <td>{{ $subject->name }}</td>
                                    <td>
                                        @if($subject->type == 'theory')
                                            <span class="badge bg-info">Theory</span>
                                        @elseif($subject->type == 'practical')
                                            <span class="badge bg-warning">Practical</span>
                                        @else
                                            <span class="badge bg-success">Both</span>
                                        @endif
                                    </td>
                                    <td>{{ $subject->theory_marks }}</td>
                                    <td>{{ $subject->practical_marks }}</td>
                                    <td><strong>{{ $subject->theory_marks + $subject->practical_marks }}</strong></td>
                                    <td>
                                        <span class="badge bg-primary">{{ $subject->classes->count() }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $subject->teachers->count() }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.subjects.show', $subject) }}" class="btn btn-info" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.subjects.edit', $subject) }}" class="btn btn-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger delete-subject" 
                                                    data-id="{{ $subject->id }}" data-name="{{ $subject->name }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                            <form id="delete-form-{{ $subject->id }}" 
                                                  action="{{ route('admin.subjects.destroy', $subject) }}" 
                                                  method="POST" style="display: none;">
                                                @csrf @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="9" class="text-center">No subjects found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $subjects->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.delete-subject').click(function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "Delete this subject?",
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