@extends('layouts.admin')

@section('title', 'Add New Teacher')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-person-plus"></i> Add New Teacher
                    </h6>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.teachers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mb-3">Personal Information</h5>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label>First Name *</label>
                                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Last Name *</label>
                                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label>Gender *</label>
                                        <select name="gender" class="form-control" required>
                                            <option value="">Select</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Date of Birth *</label>
                                        <input type="date" name="dob" class="form-control" required>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label>Photo</label>
                                    <input type="file" name="photo" class="form-control" accept="image/*">
                                </div>
                                
                                <h5 class="mb-3 mt-4">Contact Information</h5>
                                <div class="mb-3">
                                    <label>Email *</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Phone *</label>
                                    <input type="text" name="phone" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Address *</label>
                                    <textarea name="address" class="form-control" rows="2" required></textarea>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <h5 class="mb-3">Professional Information</h5>
                                <div class="mb-3">
                                    <label>Qualification *</label>
                                    <input type="text" name="qualification" class="form-control" placeholder="e.g., M.Sc, B.Ed" required>
                                </div>
                                <div class="mb-3">
                                    <label>Specialization *</label>
                                    <input type="text" name="specialization" class="form-control" placeholder="e.g., Mathematics, Science" required>
                                </div>
                                <div class="mb-3">
                                    <label>Joining Date *</label>
                                    <input type="date" name="joining_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save Teacher</button>
                            <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection