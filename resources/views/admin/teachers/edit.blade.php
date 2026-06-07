@extends('layouts.admin')

@section('title', 'Edit Teacher - ' . $teacher->first_name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-pencil-square"></i> Edit Teacher
                    </h6>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.teachers.update', $teacher) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mb-3">Personal Information</h5>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label>First Name *</label>
                                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $teacher->first_name) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Last Name *</label>
                                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $teacher->last_name) }}" required>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label>Gender *</label>
                                        <select name="gender" class="form-control" required>
                                            <option value="male" {{ $teacher->gender == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ $teacher->gender == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="other" {{ $teacher->gender == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Date of Birth *</label>
                                        <input type="date" name="dob" class="form-control" value="{{ old('dob', $teacher->dob) }}" required>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label>Photo</label>
                                    @if($teacher->photo)
                                        <div class="mb-2"><img src="{{ Storage::url($teacher->photo) }}" width="80" class="rounded"></div>
                                    @endif
                                    <input type="file" name="photo" class="form-control" accept="image/*">
                                </div>
                                
                                <h5 class="mb-3 mt-4">Contact Information</h5>
                                <div class="mb-3">
                                    <label>Email *</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $teacher->email) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Phone *</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $teacher->phone) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Address *</label>
                                    <textarea name="address" class="form-control" rows="2" required>{{ old('address', $teacher->address) }}</textarea>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <h5 class="mb-3">Professional Information</h5>
                                <div class="mb-3">
                                    <label>Qualification *</label>
                                    <input type="text" name="qualification" class="form-control" value="{{ old('qualification', $teacher->qualification) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Specialization *</label>
                                    <input type="text" name="specialization" class="form-control" value="{{ old('specialization', $teacher->specialization) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Joining Date *</label>
                                    <input type="date" name="joining_date" class="form-control" value="{{ old('joining_date', $teacher->joining_date) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Status *</label>
                                    <select name="status" class="form-control" required>
                                        <option value="active" {{ $teacher->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ $teacher->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="on_leave" {{ $teacher->status == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update Teacher</button>
                            <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection