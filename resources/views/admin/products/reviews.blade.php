@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body" style="background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%); min-height: 100vh; padding: 30px 0;">
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="text-white mb-1">
                            <i class="fas fa-star-half-alt me-3"></i>Product Reviews Management
                        </h2>
                        <p class="text-white-50 mb-0">Monitor and manage customer reviews and ratings</p>
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
                            <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-star text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-warning mb-1">4.8</h3>
                        <p class="text-muted mb-0">Average Rating</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-comments text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-success mb-1">1,234</h3>
                        <p class="text-muted mb-0">Total Reviews</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-info d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-thumbs-up text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-info mb-1">89%</h3>
                        <p class="text-muted mb-0">Positive Reviews</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.95); border-radius: 15px;">
                    <div class="card-body text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="rounded-circle bg-danger d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-flag text-white fa-2x"></i>
                            </div>
                        </div>
                        <h3 class="text-danger mb-1">12</h3>
                        <p class="text-muted mb-0">Reported Reviews</p>
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
                                <i class="fas fa-star-half-alt me-2"></i>Review Analytics & Management
                            </h5>
                            <div class="d-flex gap-2">
                                <button class="btn btn-success btn-sm">
                                    <i class="fas fa-plus me-2"></i>Add Review
                                </button>
                                <button class="btn btn-info btn-sm">
                                    <i class="fas fa-chart-bar me-2"></i>Analytics
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <!-- Review Filters -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <select class="form-control form-control-sm">
                                    <option>All Products</option>
                                    <option>Digital Marketing Course</option>
                                    <option>SEO Toolkit</option>
                                    <option>Brand Template</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control form-control-sm">
                                    <option>All Ratings</option>
                                    <option>5 Stars</option>
                                    <option>4 Stars</option>
                                    <option>3 Stars</option>
                                    <option>2 Stars</option>
                                    <option>1 Star</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control form-control-sm">
                                    <option>All Status</option>
                                    <option>Published</option>
                                    <option>Pending</option>
                                    <option>Flagged</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary btn-sm w-100">
                                    <i class="fas fa-search me-2"></i>Filter Reviews
                                </button>
                            </div>
                        </div>

                        <!-- Reviews Table -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-3 py-3">Customer</th>
                                        <th class="border-0 px-3 py-3">Product</th>
                                        <th class="border-0 px-3 py-3">Rating</th>
                                        <th class="border-0 px-3 py-3">Review</th>
                                        <th class="border-0 px-3 py-3">Date</th>
                                        <th class="border-0 px-3 py-3">Status</th>
                                        <th class="border-0 px-3 py-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $reviews = [
                                            [
                                                'customer' => 'Mohammad Ali',
                                                'product' => 'Complete Digital Marketing Masterclass',
                                                'rating' => 5,
                                                'review' => 'Excellent course! Very comprehensive and practical. Learned so much about digital marketing strategies.',
                                                'date' => '2024-01-15',
                                                'status' => 'Published',
                                                'status_class' => 'success'
                                            ],
                                            [
                                                'customer' => 'Fatema Begum',
                                                'product' => 'SEO Toolkit Pro',
                                                'rating' => 4,
                                                'review' => 'Great toolkit with lots of useful features. The keyword research tool is particularly helpful.',
                                                'date' => '2024-01-14',
                                                'status' => 'Published',
                                                'status_class' => 'success'
                                            ],
                                            [
                                                'customer' => 'Rahim Hossain',
                                                'product' => 'React Admin Dashboard',
                                                'rating' => 5,
                                                'review' => 'Perfect for my project! Clean code, well documented, and easy to customize.',
                                                'date' => '2024-01-13',
                                                'status' => 'Published',
                                                'status_class' => 'success'
                                            ],
                                            [
                                                'customer' => 'Nasrin Akter',
                                                'product' => 'Brand Identity Kit',
                                                'rating' => 3,
                                                'review' => 'Good quality files, but could use more color variations in the templates.',
                                                'date' => '2024-01-12',
                                                'status' => 'Pending',
                                                'status_class' => 'warning'
                                            ],
                                            [
                                                'customer' => 'Karim Mia',
                                                'product' => 'Python Programming Course',
                                                'rating' => 2,
                                                'review' => 'Content is outdated and some examples don\'t work with current Python versions.',
                                                'date' => '2024-01-11',
                                                'status' => 'Flagged',
                                                'status_class' => 'danger'
                                            ],
                                        ];
                                    @endphp
                                    @foreach($reviews as $review)
                                    <tr>
                                        <td class="px-3 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-3">
                                                    <div class="avatar-initial rounded-circle bg-primary text-white">
                                                        {{ substr($review['customer'], 0, 1) }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $review['customer'] }}</div>
                                                    <small class="text-muted">customer@example.com</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-3 py-3">
                                            <div class="fw-bold">{{ Str::limit($review['product'], 30) }}</div>
                                            <small class="text-muted">#PROD-{{ str_pad($loop->iteration, 3, '0', STR_PAD_LEFT) }}</small>
                                        </td>
                                        <td class="px-3 py-3">
                                            <div class="d-flex align-items-center">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $review['rating'] ? 'text-warning' : 'text-muted' }} me-1"></i>
                                                @endfor
                                                <span class="ms-2 fw-bold">{{ $review['rating'] }}</span>
                                            </div>
                                        </td>
                                        <td class="px-3 py-3">
                                            <div class="review-text">
                                                {{ Str::limit($review['review'], 80) }}
                                                @if(strlen($review['review']) > 80)
                                                    <a href="#" class="text-primary ms-1" onclick="return false;">Read more</a>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-3 py-3">{{ $review['date'] }}</td>
                                        <td class="px-3 py-3">
                                            <span class="badge bg-{{ $review['status_class'] }} px-2 py-1">{{ $review['status'] }}</span>
                                        </td>
                                        <td class="px-3 py-3 text-center">
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-outline-primary" title="View Full Review">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-outline-success" title="Approve">
                                                    <i class="fas fa-check"></i>
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

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Showing 1 to 5 of 247 reviews
                            </div>
                            <nav>
                                <ul class="pagination pagination-sm mb-0">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#">Previous</a>
                                    </li>
                                    <li class="page-item active">
                                        <a class="page-link" href="#">1</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">2</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">3</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                        <hr class="my-4">

                        <!-- Quick Actions -->
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fas fa-reply text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Bulk Actions</h6>
                                        <small class="text-muted">Approve, reject, or delete multiple reviews</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-info rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fas fa-chart-bar text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Analytics</h6>
                                        <small class="text-muted">View review trends and ratings analysis</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fas fa-envelope text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Notifications</h6>
                                        <small class="text-muted">Configure review notification settings</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Review Moderation</h6>
                                        <p class="text-muted mb-0">Approve, edit, or reject reviews to maintain quality standards.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fas fa-chart-bar text-white"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Review Analytics</h6>
                                        <p class="text-muted mb-0">Track review trends, ratings distribution, and customer sentiment.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-info rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fas fa-reply text-white"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Response Management</h6>
                                        <p class="text-muted mb-0">Reply to customer reviews and manage public conversations.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fas fa-shield-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Spam Protection</h6>
                                        <p class="text-muted mb-0">Automatic spam detection and manual review of suspicious reviews.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Review Summary Stats -->
                        <div class="row text-center mb-4">
                            <div class="col-md-3">
                                <div class="p-3 bg-light rounded">
                                    <h4 class="text-success mb-1">4.6</h4>
                                    <small class="text-muted">Average Rating</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="p-3 bg-light rounded">
                                    <h4 class="text-primary mb-1">2,156</h4>
                                    <small class="text-muted">Total Reviews</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="p-3 bg-light rounded">
                                    <h4 class="text-info mb-1">87%</h4>
                                    <small class="text-muted">Positive Reviews</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="p-3 bg-light rounded">
                                    <h4 class="text-warning mb-1">34</h4>
                                    <small class="text-muted">Pending Moderation</small>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fas fa-reply text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Response Templates</h6>
                                        <small class="text-muted">Manage canned responses for common review types</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="bg-info rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fas fa-flag text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Review Guidelines</h6>
                                        <small class="text-muted">Set community guidelines and moderation rules</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <h4 class="text-primary mb-3">Advanced Review Management Coming Soon</h4>
                            <p class="text-muted mb-4">We're developing comprehensive review management tools to help you engage with customers and maintain product reputation.</p>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.products.index') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-box me-2"></i>Manage Products
                                </a>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary btn-lg">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a>
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
    .bg-danger { background-color: #dc3545 !important; }
    .text-primary { color: #007bff !important; }
    .text-success { color: #28a745 !important; }
    .text-warning { color: #ffc107 !important; }
    .text-info { color: #17a2b8 !important; }
    .text-danger { color: #dc3545 !important; }
    .text-muted { color: #6c757d !important; }
    .text-white { color: #ffffff !important; }
    .text-white-50 { color: rgba(255,255,255,0.5) !important; }
</style>
@endsection