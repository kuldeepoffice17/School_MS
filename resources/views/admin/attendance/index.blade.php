@extends('layouts.admin')

@section('title', 'Mark Attendance')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-calendar-check"></i> Mark Attendance
                    </h6>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('admin.attendance.index') }}" class="mb-4">
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
                                <label class="form-label">Select Section *</label>
                                <select name="section_id" id="section_id" class="form-control" required>
                                    <option value="">Select Section</option>
                                    @if($selectedSection)
                                        @foreach($selectedClass->sections ?? [] as $section)
                                            <option value="{{ $section->id }}" {{ request('section_id') == $section->id ? 'selected' : '' }}>
                                                {{ $section->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Date</label>
                                <input type="date" name="date" class="form-control" value="{{ $date }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-search"></i> Load Students
                                </button>
                            </div>
                        </div>
                    </form>

                    @if($students->count() > 0)
                        <form method="POST" action="{{ route('admin.attendance.mark') }}">
                            @csrf
                            <input type="hidden" name="class_id" value="{{ request('class_id') }}">
                            <input type="hidden" name="section_id" value="{{ request('section_id') }}">
                            <input type="hidden" name="date" value="{{ $date }}">
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Roll No</th>
                                            <th>Student Name</th>
                                            <th>Admission No</th>
                                            <th>Status</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($students as $student)
                                        <tr>
                                            <td>{{ $student->roll_no ?? 'N/A' }}</td>
                                            <td>
                                                <strong>{{ $student->first_name }} {{ $student->last_name }}</strong>
                                            </td>
                                            <td>{{ $student->admission_no }}</td>
                                            <td>
                                                <select name="attendance[{{ $student->id }}][status]" class="form-control" style="width: 130px;" required>
                                                    <option value="present" {{ isset($attendanceData[$student->id]) && $attendanceData[$student->id]->status == 'present' ? 'selected' : '' }}>
                                                        ✅ Present
                                                    </option>
                                                    <option value="absent" {{ isset($attendanceData[$student->id]) && $attendanceData[$student->id]->status == 'absent' ? 'selected' : '' }}>
                                                        ❌ Absent
                                                    </option>
                                                    <option value="late" {{ isset($attendanceData[$student->id]) && $attendanceData[$student->id]->status == 'late' ? 'selected' : '' }}>
                                                        ⏰ Late
                                                    </option>
                                                    <option value="half_day" {{ isset($attendanceData[$student->id]) && $attendanceData[$student->id]->status == 'half_day' ? 'selected' : '' }}>
                                                        🌓 Half Day
                                                    </option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="attendance[{{ $student->id }}][remarks]" 
                                                       class="form-control" placeholder="Optional remarks"
                                                       value="{{ $attendanceData[$student->id]->remarks ?? '' }}">
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Save Attendance
                                </button>
                            </div>
                        </form>
                    @elseif(request('class_id') && request('section_id'))
                        <div class="alert alert-info text-center">
                            <i class="bi bi-info-circle"></i> No students found in this class/section.
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
    // Load sections when class changes
    $('#class_id').change(function() {
        var classId = $(this).val();
        if(classId) {
            $.ajax({
                url: '/admin/get-sections/' + classId,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#section_id').empty();
                    $('#section_id').append('<option value="">Select Section</option>');
                    $.each(data, function(key, value) {
                        $('#section_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        } else {
            $('#section_id').empty();
            $('#section_id').append('<option value="">Select Section</option>');
        }
    });
});
</script>
@endpush