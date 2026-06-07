@extends('layouts.admin')

@section('title', 'Section Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-layers"></i> Section Management
                    </h6>
                    <a href="{{ route('admin.sections.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle"></i> Add New Section
                    </a>
                </div>
                <div class="card-body">
                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('admin.sections.index') }}" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Search by section name..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-4">
                                <select name="class_id" class="form-control">
                                    <option value="">All Classes</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }} ({{ $class->numeric_name }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-search"></i> Filter
                                </button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('admin.sections.index') }}" class="btn btn-secondary w-100">
                                    <i class="bi bi-arrow-repeat"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Sections Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Section Name</th>
                                    <th>Class</th>
                                    <th>Capacity</th>
                                    <th>Students Enrolled</th>
                                    <th>Available Seats</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th width="120">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sections as $section)
                                <tr>
                                    <td><strong>{{ $section->name }}</strong></td>
                                    <td>{{ $section->class->name }} ({{ $section->class->numeric_name }})</td>
                                    <td>{{ $section->capacity }}</td>
                                    <td>{{ $section->students->count() }}</td>
                                    <td>
                                        @php $available = $section->capacity - $section->students->count(); @endphp
                                        @if($available > 10)
                                            <span class="badge bg-success">{{ $available }} seats</span>
                                        @elseif($available > 0)
                                            <span class="badge bg-warning">{{ $available }} seats</span>
                                        @else
                                            <span class="badge bg-danger">Full</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($available > 0)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Full</span>
                                        @endif
                                    </td>
                                    <td>{{ $section->created_at ? $section->created_at->format('d M Y') : 'N/A' }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.sections.show', $section) }}" 
                                               class="btn btn-info" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.sections.edit', $section) }}" 
                                               class="btn btn-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-danger delete-section" 
                                                    data-id="{{ $section->id }}"
                                                    data-name="{{ $section->name }}"
                                                    title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                            <form id="delete-form-{{ $section->id }}" 
                                                  action="{{ route('admin.sections.destroy', $section) }}" 
                                                  method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">No sections found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $sections->appends(request()->query())->links() }}
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
        $('.delete-section').click(function(e) {
            e.preventDefault();
            let sectionId = $(this).data('id');
            let sectionName = $(this).data('name');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete section: " + sectionName + "?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + sectionId).submit();
                }
            });
        });
    });
</script>
@endpush