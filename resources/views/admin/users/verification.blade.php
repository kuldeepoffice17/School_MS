@extends('layouts.admin')

@section('title', 'User Verification')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-person-check"></i> User Verification Management
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs mb-4" id="verificationTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" 
                                    data-bs-target="#pending" type="button" role="tab">
                                <i class="bi bi-clock-history"></i> Pending Requests
                                <span class="badge bg-warning ms-2">{{ $pendingUsers->total() }}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="verified-tab" data-bs-toggle="tab" 
                                    data-bs-target="#verified" type="button" role="tab">
                                <i class="bi bi-check-circle"></i> Verified Users
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- Pending Users Tab -->
                        <div class="tab-pane fade show active" id="pending" role="tabpanel">
                            @if($pendingUsers->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Role</th>
                                                <th>Registered</th>
                                                <th width="200">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pendingUsers as $user)
                                            <tr>
                                                <td><strong>{{ $user->name }}</strong></td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $user->role == 'teacher' ? 'primary' : ($user->role == 'student' ? 'success' : 'warning') }}">
                                                        {{ ucfirst($user->role) }}
                                                    </span>
                                                </td>
                                                <td>{{ $user->created_at->diffForHumans() }}</td>
                                                <td>
                                                    <button class="btn btn-success btn-sm verify-user" 
                                                            data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                                                        <i class="bi bi-check-circle"></i> Verify
                                                    </button>
                                                    <button class="btn btn-danger btn-sm reject-user" 
                                                            data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                                                        <i class="bi bi-x-circle"></i> Reject
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $pendingUsers->links() }}
                            @else
                                <div class="text-center py-5">
                                    <i class="bi bi-check-circle fs-1 text-success"></i>
                                    <p class="mt-2 text-muted">No pending verification requests.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Verified Users Tab -->
                        <div class="tab-pane fade" id="verified" role="tabpanel">
                            @if($verifiedUsers->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Verified At</th>
                                                <th>Verified By</th>
                                                <th width="100">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($verifiedUsers as $user)
                                            <tr>
                                                <td><strong>{{ $user->name }}</strong></td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $user->role == 'teacher' ? 'primary' : ($user->role == 'student' ? 'success' : 'warning') }}">
                                                        {{ ucfirst($user->role) }}
                                                    </span>
                                                </td>
                                                <td>{{ $user->verified_at ? $user->verified_at->format('d M Y, h:i A') : 'N/A' }}</td>
                                                <td>{{ $user->verifier->name ?? 'Admin' }}</td>
                                                <td>
                                                    <button class="btn btn-danger btn-sm delete-user" 
                                                            data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $verifiedUsers->links() }}
                            @else
                                <div class="text-center py-5">
                                    <i class="bi bi-person fs-1 text-muted"></i>
                                    <p class="mt-2 text-muted">No verified users yet.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p>You are about to reject: <strong id="rejectUserName"></strong></p>
                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason for rejection <span class="text-danger">*</span></label>
                        <textarea name="reason" id="reason" class="form-control" rows="3" 
                                  placeholder="Please provide a reason for rejection..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Verify User
    $('.verify-user').click(function() {
        let userId = $(this).data('id');
        let userName = $(this).data('name');
        let $row = $(this).closest('tr');
        
        Swal.fire({
            title: 'Verify User',
            text: "Are you sure you want to verify " + userName + "?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Yes, verify!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.users.verify', ['user' => ':id']) }}".replace(':id', userId),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Verified!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            // Remove row from pending and refresh
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        } else {
                            Swal.fire('Error!', response.error || 'Something went wrong.', 'error');
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'Something went wrong.';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMsg = xhr.responseJSON.error;
                        }
                        Swal.fire('Error!', errorMsg, 'error');
                    }
                });
            }
        });
    });

    // Reject User - Show modal
    let rejectUserId = null;
    $('.reject-user').click(function() {
        rejectUserId = $(this).data('id');
        let userName = $(this).data('name');
        $('#rejectUserName').text(userName);
        $('#reason').val(''); // Clear previous reason
        $('#rejectModal').modal('show');
    });

    // Submit reject form
    $('#rejectForm').submit(function(e) {
        e.preventDefault();
        let reason = $('#reason').val();
        
        if (!reason.trim()) {
            Swal.fire('Error!', 'Please provide a reason for rejection.', 'error');
            return;
        }

        // Show loading
        Swal.fire({
            title: 'Rejecting...',
            text: 'Please wait',
            allowOutsideClick: false,
            didOpen: function() {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: "{{ route('admin.users.reject', ['user' => ':id']) }}".replace(':id', rejectUserId),
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                reason: reason
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Rejected!',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    $('#rejectModal').modal('hide');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    Swal.fire('Error!', response.error || 'Something went wrong.', 'error');
                }
            },
            error: function(xhr) {
                let errorMsg = 'Something went wrong.';
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMsg = xhr.responseJSON.error;
                }
                Swal.fire('Error!', errorMsg, 'error');
            }
        });
    });

    // Delete User
    $('.delete-user').click(function() {
        let userId = $(this).data('id');
        let userName = $(this).data('name');
        
        Swal.fire({
            title: 'Delete User',
            text: "Are you sure you want to delete " + userName + "? This cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.users.delete', ['user' => ':id']) }}".replace(':id', userId),
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        } else {
                            Swal.fire('Error!', response.error || 'Something went wrong.', 'error');
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'Something went wrong.';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMsg = xhr.responseJSON.error;
                        }
                        Swal.fire('Error!', errorMsg, 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush
{{-- @push('scripts')
<script>
$(document).ready(function() {
    // Verify User
    $('.verify-user').click(function() {
        let userId = $(this).data('id');
        let userName = $(this).data('name');
        
        Swal.fire({
            title: 'Verify User',
            text: "Are you sure you want to verify " + userName + "?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Yes, verify!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                   url: "{{ route('admin.users.verify', ['user' => ':id']) }}".replace(':id', userId),

                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Verified!', response.message, 'success');
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Something went wrong.', 'error');
                    }
                });
            }
        });
    });

    // Reject User - Show modal
    let rejectUserId = null;
    $('.reject-user').click(function() {
        rejectUserId = $(this).data('id');
        let userName = $(this).data('name');
        $('#rejectUserName').text(userName);
        $('#rejectModal').modal('show');
    });

    // Submit reject form
    $('#rejectForm').submit(function(e) {
        e.preventDefault();
        let reason = $('#reason').val();
        
        if (!reason.trim()) {
            Swal.fire('Error!', 'Please provide a reason for rejection.', 'error');
            return;
        }

        $.ajax({
           url: "{{ route('admin.users.reject', ['user' => ':id']) }}".replace(':id', rejectUserId),
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                reason: reason
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire('Rejected!', response.message, 'info');
                    $('#rejectModal').modal('hide');
                    location.reload();
                }
            },
            error: function(xhr) {
                Swal.fire('Error!', 'Something went wrong.', 'error');
            }
        });
    });

    // Delete User
    $('.delete-user').click(function() {
        let userId = $(this).data('id');
        let userName = $(this).data('name');
        
        Swal.fire({
            title: 'Delete User',
            text: "Are you sure you want to delete " + userName + "? This cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                   url: "{{ route('admin.users.delete', ['user' => ':id']) }}".replace(':id', userId),
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Deleted!', response.message, 'success');
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', xhr.responseJSON?.error || 'Something went wrong.', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush --}}