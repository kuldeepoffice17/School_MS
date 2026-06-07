@extends('layouts.admin')

@section('title', 'Exam Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-file-text"></i> Exam Management
                    </h6>
                    <a href="{{ route('admin.exams.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle"></i> Add New Exam
                    </a>
                </div>
                <div class="card-body">
                    <form method="GET" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="Search exams..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="term" class="form-control">
                                    <option value="">All Terms</option>
                                    <option value="first_term" {{ request('term') == 'first_term' ? 'selected' : '' }}>First Term</option>
                                    <option value="second_term" {{ request('term') == 'second_term' ? 'selected' : '' }}>Second Term</option>
                                    <option value="third_term" {{ request('term') == 'third_term' ? 'selected' : '' }}>Third Term</option>
                                    <option value="final" {{ request('term') == 'final' ? 'selected' : '' }}>Final</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Filter</button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('admin.exams.index') }}" class="btn btn-secondary w-100">Reset</a>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Exam Name</th>
                                    <th>Term</th>
                                    <th>Academic Year</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th width="150">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($exams as $exam)
                                <tr>
                                    <td><strong>{{ $exam->name }}</strong></td>
                                    <td>
                                        @if($exam->term == 'first_term') First Term
                                        @elseif($exam->term == 'second_term') Second Term
                                        @elseif($exam->term == 'third_term') Third Term
                                        @else Final
                                        @endif
                                    </td>
                                    <td>{{ $exam->academicYear->name ?? 'N/A' }}</td>
                                    <td>{{ date('d M Y', strtotime($exam->start_date)) }}</td>
                                    <td>{{ date('d M Y', strtotime($exam->end_date)) }}</td>
                                    <td>
                                        @if($exam->exam_status == 'upcoming')
                                            <span class="badge bg-info">Upcoming</span>
                                        @elseif($exam->exam_status == 'ongoing')
                                            <span class="badge bg-warning">Ongoing</span>
                                        @else
                                            <span class="badge bg-success">Completed</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.exams.show', $exam) }}" class="btn btn-info"><i class="bi bi-eye"></i></a>
                                            <a href="{{ route('admin.exams.edit', $exam) }}" class="btn btn-primary"><i class="bi bi-pencil"></i></a>
                                            <a href="{{ route('admin.exams.routine', $exam) }}" class="btn btn-warning"><i class="bi bi-calendar"></i></a>
                                            <a href="{{ route('admin.exams.marks-entry', $exam) }}" class="btn btn-success"><i class="bi bi-pencil-square"></i></a>
                                            <button class="btn btn-danger delete-exam" data-id="{{ $exam->id }}" data-name="{{ $exam->name }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                            <form id="delete-form-{{ $exam->id }}" action="{{ route('admin.exams.destroy', $exam) }}" method="POST" style="display:none;">
                                                @csrf @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="7" class="text-center">No exams found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $exams->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.delete-exam').click(function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
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