@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 30px 0;">
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="text-white mb-1">
                            <i class="fas fa-cloud-download-alt me-3"></i>Digital Downloads Management
                        </h2>
                        <p class="text-white-50 mb-0">Manage and track your digital product downloads</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-light">
                            <i class="fas fa-plus me-2"></i>Add Product
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-light">
                            <i class="fas fa-arrow-left me-2"></i>Back to Products
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-file-download text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-primary mb-1">1,247</h3>
                        <p class="text-muted mb-0">Total Downloads</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-box text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-success mb-1">89</h3>
                        <p class="text-muted mb-0">Digital Products</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-clock text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-warning mb-1">23</h3>
                        <p class="text-muted mb-0">Pending Downloads</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-info d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-chart-line text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-info mb-1">$12,847</h3>
                        <p class="text-muted mb-0">Revenue Generated</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-primary">
                                <i class="fas fa-cogs me-2"></i>Download Management Features
                            </h5>
                            <span class="badge badge-primary">Coming Soon</span>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <!-- Upload Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="border-dashed border-2 border-primary rounded p-4 text-center" style="border-style: dashed !important;">
                                    <div class="mb-3">
                                        <i class="fas fa-cloud-upload-alt text-primary" style="font-size: 48px;"></i>
                                    </div>
                                    <h5 class="text-primary mb-3">Upload Digital Files</h5>
                                    <p class="text-muted mb-3">Drag and drop files here or click to browse</p>
                                    <button class="btn btn-primary btn-lg">
                                        <i class="fas fa-folder-open me-2"></i>Choose Files
                                    </button>
                                    <input type="file" class="d-none" multiple>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Downloads Table -->
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3 text-primary">
                                    <i class="fas fa-file-download me-2"></i>Recent Downloads
                                </h5>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>File Name</th>
                                                <th>Size</th>
                                                <th>Type</th>
                                                <th>Downloads</th>
                                                <th>Last Downloaded</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $files = [
                                                    ['name' => 'digital-marketing-course.zip', 'size' => '2.4 GB', 'type' => 'ZIP Archive', 'downloads' => 145, 'last' => '2 hours ago'],
                                                    ['name' => 'seo-toolkit.pdf', 'size' => '15.2 MB', 'type' => 'PDF Document', 'downloads' => 89, 'last' => '5 hours ago'],
                                                    ['name' => 'brand-template.psd', 'size' => '45.8 MB', 'type' => 'Photoshop File', 'downloads' => 67, 'last' => '1 day ago'],
                                                    ['name' => 'web-development-guide.epub', 'size' => '8.9 MB', 'type' => 'eBook', 'downloads' => 123, 'last' => '3 hours ago'],
                                                ];
                                            @endphp
                                            @foreach($files as $file)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-file-archive text-primary me-3"></i>
                                                        <div>
                                                            <div class="fw-bold">{{ $file['name'] }}</div>
                                                            <small class="text-muted">ID: #FILE-{{ str_pad($loop->iteration, 3, '0', STR_PAD_LEFT) }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $file['size'] }}</td>
                                                <td><span class="badge bg-info">{{ $file['type'] }}</span></td>
                                                <td><span class="badge bg-success">{{ $file['downloads'] }}</span></td>
                                                <td>{{ $file['last'] }}</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <button class="btn btn-outline-primary" title="Download">
                                                            <i class="fas fa-download"></i>
                                                        </button>
                                                        <button class="btn btn-outline-warning" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-outline-danger" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fas fa-chart-line text-white"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Download Analytics</h6>
                                        <p class="text-muted mb-0 small">View detailed download statistics and user engagement metrics.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-info rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fas fa-shield-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Access Management</h6>
                                        <p class="text-muted mb-0 small">Control who can access and download your digital files.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
    }
    .rounded-circle {
        border-radius: 50% !important;
    }
    .badge-primary {
        background-color: #007bff;
    }
    .bg-primary { background-color: #007bff !important; }
    .bg-success { background-color: #28a745 !important; }
    .bg-warning { background-color: #ffc107 !important; }
    .bg-info { background-color: #17a2b8 !important; }
    .text-primary { color: #007bff !important; }
    .text-success { color: #28a745 !important; }
    .text-warning { color: #ffc107 !important; }
    .text-info { color: #17a2b8 !important; }
    .text-muted { color: #6c757d !important; }
    .text-white { color: #ffffff !important; }
    .text-white-50 { color: rgba(255,255,255,0.5) !important; }
</style>
@endsection