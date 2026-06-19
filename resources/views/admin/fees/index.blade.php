@extends('layouts.admin')

@section('title', 'Fees Management')

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Total Fees</p>
                        <h3 class="mb-0">₹{{ number_format($totalFees, 2) }}</h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 p-3 rounded">
                        <i class="bi bi-currency-rupee fs-1 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Collected Amount</p>
                        <h3 class="mb-0 text-success">₹{{ number_format($totalCollected, 2) }}</h3>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded">
                        <i class="bi bi-check-circle fs-1 text-success"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Due Amount</p>
                        <h3 class="mb-0 text-danger">₹{{ number_format($totalDue, 2) }}</h3>
                    </div>
                    <div class="bg-danger bg-opacity-10 p-3 rounded">
                        <i class="bi bi-exclamation-triangle fs-1 text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Collection Rate</p>
                        <h3 class="mb-0">{{ $collectionRate }}%</h3>
                    </div>
                    <div class="bg-info bg-opacity-10 p-3 rounded">
                        <i class="bi bi-graph-up fs-1 text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-currency-dollar"></i> Fees Management
                    </h6>
                    <div>
                        <a href="{{ route('admin.fees.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle"></i> Add New Fee
                        </a>
                        <a href="{{ route('admin.fees.collection') }}" class="btn btn-info btn-sm">
                            <i class="bi bi-file-text"></i> Collection Report
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('admin.fees.index') }}" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Search student..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="class_id" class="form-control">
                                    <option value="">All Classes</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="fee_type" class="form-control">
                                    <option value="">All Fee Types</option>
                                    <option value="tuition" {{ request('fee_type') == 'tuition' ? 'selected' : '' }}>Tuition</option>
                                    <option value="admission" {{ request('fee_type') == 'admission' ? 'selected' : '' }}>Admission</option>
                                    <option value="exam" {{ request('fee_type') == 'exam' ? 'selected' : '' }}>Exam</option>
                                    <option value="library" {{ request('fee_type') == 'library' ? 'selected' : '' }}>Library</option>
                                    <option value="sports" {{ request('fee_type') == 'sports' ? 'selected' : '' }}>Sports</option>
                                    <option value="transport" {{ request('fee_type') == 'transport' ? 'selected' : '' }}>Transport</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-control">
                                    <option value="">All Status</option>
                                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>Partial</option>
                                    <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </div>
                    </form>

                    <!-- Fees Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Student</th>
                                    <th>Class</th>
                                    <th>Fee Type</th>
                                    <th>Amount</th>
                                    <th>Paid</th>
                                    <th>Due</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th width="120">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($fees as $fee)
                                <tr>
                                    <td>
                                        <strong>{{ $fee->student->full_name ?? 'N/A' }}</strong><br>
                                        <small class="text-muted">ID: {{ $fee->student->admission_no ?? 'N/A' }}</small>
                                    </td>
                                    <td>{{ $fee->student->class->name ?? 'N/A' }} {{ $fee->student->section->name ?? '' }}</td>
                                    <td>{!! $fee->fee_type_badge_attribute !!}</td>
                                    <td>₹{{ number_format($fee->amount, 2) }}</td>
                                    <td>₹{{ number_format($fee->paid_amount, 2) }}</td>
                                    <td>₹{{ number_format($fee->due_amount, 2) }}</td>
                                    <td>
                                        @if($fee->due_date < now() && $fee->status != 'paid')
                                            <span class="text-danger">Overdue</span><br>
                                        @endif
                                        {{ date('d M Y', strtotime($fee->due_date)) }}
                                    </td>
                                    <td>{!! $fee->status_badge_attribute !!}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.fees.show', $fee) }}" class="btn btn-info" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.fees.edit', $fee) }}" class="btn btn-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button class="btn btn-danger delete-fee" data-id="{{ $fee->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                            <form id="delete-form-{{ $fee->id }}" 
                                                  action="{{ route('admin.fees.destroy', $fee) }}" 
                                                  method="POST" style="display: none;">
                                                @csrf @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="9" class="text-center">No fee records found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $fees->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.delete-fee').click(function() {
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