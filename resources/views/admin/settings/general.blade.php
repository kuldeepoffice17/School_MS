@extends('layouts.admin')

@section('title', 'General Settings')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-gear"></i> General Settings
                    </h6>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <ul class="nav nav-tabs mb-4">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#school-info">School Information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#logo">Logo & Favicon</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- School Information Tab -->
                        <div class="tab-pane fade show active" id="school-info">
                            <form action="{{ route('admin.settings.update-general') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>School Name *</label>
                                            <input type="text" name="school_name" class="form-control" 
                                                   value="{{ \App\Models\Setting::get('school_name', 'School Management System') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>School Email *</label>
                                            <input type="email" name="school_email" class="form-control" 
                                                   value="{{ \App\Models\Setting::get('school_email') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>School Phone *</label>
                                            <input type="text" name="school_phone" class="form-control" 
                                                   value="{{ \App\Models\Setting::get('school_phone') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>School Website</label>
                                            <input type="url" name="school_website" class="form-control" 
                                                   value="{{ \App\Models\Setting::get('school_website') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Established Year</label>
                                            <input type="number" name="established_year" class="form-control" 
                                                   value="{{ \App\Models\Setting::get('established_year') }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label>School Address *</label>
                                            <textarea name="school_address" class="form-control" rows="3" required>{{ \App\Models\Setting::get('school_address') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Save Settings</button>
                            </form>
                        </div>

                        <!-- Logo Tab -->
                        <div class="tab-pane fade" id="logo">
                            <form action="{{ route('admin.settings.update-logo') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6 text-center">
                                        <div class="mb-3">
                                            <label>Current Logo</label><br>
                                            @php $logo = \App\Models\Setting::get('school_logo'); @endphp
                                            @if($logo && Storage::disk('public')->exists($logo))
                                                <img src="{{ Storage::url($logo) }}" alt="School Logo" 
                                                     style="max-width: 200px; max-height: 100px;" class="border p-2 mb-3">
                                            @else
                                                <div class="border p-5 mb-3">No Logo Uploaded</div>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <label>Upload New Logo</label>
                                            <input type="file" name="logo" class="form-control" accept="image/*" required>
                                            <small class="text-muted">Recommended size: 200x100px. Max: 2MB</small>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Upload Logo</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection