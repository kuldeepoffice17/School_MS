@extends('layouts.admin')

@section('title', 'Attendance Report')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-graph-up"></i> Attendance Report
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('admin.attendance.report') }}" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Select Class *</label>
                                <select name="class_id" id="class_id" class="form-control" required>
                                    <option value="">Select Class</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }} ({{ $class->numeric_name }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Select Section</label>
                                <select name="section_id" id="section_id" class="form-control">
                                    <option value="">All Sections</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Month</label>
                                <input type="month" name="month" class="form-control" value="{{ request('month', date('Y-m')) }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-search"></i> Generate Report
                                </button>
                            </div>
                        </div>
                    </form>

                    @if(count($reportData) > 0)
                        <!-- Summary Cards -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <h6 class="card-title">Total Students</h6>
                                        <h3 class="mb-0">{{ $summary['total_students'] }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <h6 class="card-title">Total Present</h6>
                                        <h3 class="mb-0">{{ $summary['total_present'] }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-danger text-white">
                                    <div class="card-body">
                                        <h6 class="card-title">Total Absent</h6>
                                        <h3 class="mb-0">{{ $summary['total_absent'] }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-info text-white">
                                    <div class="card-body">
                                        <h6 class="card-title">Overall Attendance</h6>
                                        <h3 class="mb-0">{{ $summary['overall_percentage'] }}%</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Report Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="reportTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Roll No</th>
                                        <th>Student Name</th>
                                        <th>Admission No</th>
                                        <th>Present</th>
                                        <th>Absent</th>
                                        <th>Late</th>
                                        <th>Half Day</th>
                                        <th>Total Days</th>
                                        <th>Attendance %</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reportData as $data)
                                    <tr>
                                        <td>{{ $data['student']->roll_no ?? 'N/A' }}</td>
                                        <td>{{ $data['student']->first_name }} {{ $data['student']->last_name }}</td>
                                        <td>{{ $data['student']->admission_no }}</td>
                                        <td><span class="badge bg-success">{{ $data['present'] }}</span></td>
                                        <td><span class="badge bg-danger">{{ $data['absent'] }}</span></td>
                                        <td><span class="badge bg-warning">{{ $data['late'] }}</span></td>
                                        <td><span class="badge bg-info">{{ $data['half_day'] }}</span></td>
                                        <td>{{ $data['total_days'] }}</td>
                                        <td>
                                            @php
                                                $color = $data['percentage'] >= 75 ? 'success' : ($data['percentage'] >= 60 ? 'warning' : 'danger');
                                            @endphp
                                            <span class="badge bg-{{ $color }}">{{ $data['percentage'] }}%</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @elseif(request('class_id'))
                        <div class="alert alert-info text-center">
                            <i class="bi bi-info-circle"></i> No attendance records found for selected criteria.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#reportTable').DataTable({
        pageLength: 25,
        responsive: true,
        order: [[0, 'asc']]
    });

    // Load sections when class changes
    $('#class_id').change(function() {
        var classId = $(this).val();
        var selectedSection = '{{ request('section_id') }}';
        if(classId) {
            $.ajax({
                url: '/admin/get-sections/' + classId,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#section_id').empty();
                    $('#section_id').append('<option value="">All Sections</option>');
                    $.each(data, function(key, value) {
                        $('#section_id').append('<option value="' + value.id + '" ' + (selectedSection == value.id ? 'selected' : '') + '>' + value.name + '</option>');
                    });
                }
            });
        } else {
            $('#section_id').empty();
            $('#section_id').append('<option value="">All Sections</option>');
        }
    });
});
</script>
@endpush