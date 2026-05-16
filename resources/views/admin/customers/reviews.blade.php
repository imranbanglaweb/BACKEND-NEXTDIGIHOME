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
                            <i class="fas fa-star-half-alt me-3"></i>Customer Reviews Management
                        </h2>
                        <p class="text-white-50 mb-0">Monitor and manage customer feedback and reviews</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.customers.index') }}" class="btn btn-light">
                            <i class="fas fa-users me-2"></i>All Customers
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
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
                        <h3 class="text-warning mb-1">4.6</h3>
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
                        <h3 class="text-success mb-1">2,156</h3>
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
                        <h3 class="text-info mb-1">87%</h3>
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
                        <h3 class="text-danger mb-1">34</h3>
                        <p class="text-muted mb-0">Flagged Reviews</p>
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
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#bulkResponseModal">
                                    <i class="fas fa-reply me-2"></i>Bulk Response
                                </button>
                                <button class="btn btn-info btn-sm">
                                    <i class="fas fa-chart-bar me-2"></i>Analytics
                                </button>
                                <button class="btn btn-warning btn-sm">
                                    <i class="fas fa-cog me-2"></i>Settings
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <!-- Review Filters -->
                        <div class="row mb-4">
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Filter by Customer</label>
                                <select class="form-control form-control-sm">
                                    <option>All Customers</option>
                                    <option>Mohammad Ali</option>
                                    <option>Fatema Begum</option>
                                    <option>Rahim Hossain</option>
                                    <option>Nasrin Akter</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Review Status</label>
                                <select class="form-control form-control-sm">
                                    <option>All Reviews</option>
                                    <option>Published</option>
                                    <option>Pending</option>
                                    <option>Flagged</option>
                                    <option>Hidden</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Rating Range</label>
                                <select class="form-control form-control-sm">
                                    <option>All Ratings</option>
                                    <option>5 Stars</option>
                                    <option>4+ Stars</option>
                                    <option>3+ Stars</option>
                                    <option>1-2 Stars</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Time Period</label>
                                <select class="form-control form-control-sm">
                                    <option>Last 30 Days</option>
                                    <option>Last 90 Days</option>
                                    <option>Last 6 Months</option>
                                    <option>All Time</option>
                                </select>
                            </div>
                        </div>

                        <!-- Customer Reviews Table -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-3 py-3">Customer</th>
                                        <th class="border-0 px-3 py-3">Review</th>
                                        <th class="border-0 px-3 py-3">Rating</th>
                                        <th class="border-0 px-3 py-3">Product/Service</th>
                                        <th class="border-0 px-3 py-3">Date</th>
                                        <th class="border-0 px-3 py-3">Status</th>
                                        <th class="border-0 px-3 py-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $customerReviews = [
                                            [
                                                'customer' => 'Mohammad Ali',
                                                'email' => 'john@example.com',
                                                'review' => 'Excellent customer service! The support team was very helpful and resolved my issue quickly. Highly recommend this service.',
                                                'rating' => 5,
                                                'product' => 'Premium Support Package',
                                                'date' => '2024-01-15',
                                                'status' => 'Published',
                                                'status_class' => 'success',
                                                'helpful' => 12
                                            ],
                                            [
                                                'customer' => 'Fatema Begum',
                                                'email' => 'jane@example.com',
                                                'review' => 'Good product overall, but the setup process could be simpler. The documentation needs improvement.',
                                                'rating' => 3,
                                                'product' => 'Business Tools Suite',
                                                'date' => '2024-01-14',
                                                'status' => 'Published',
                                                'status_class' => 'success',
                                                'helpful' => 8
                                            ],
                                            [
                                                'customer' => 'Rahim Hossain',
                                                'email' => 'mike@example.com',
                                                'review' => 'Outstanding experience! The team went above and beyond to ensure everything worked perfectly. Will definitely use again.',
                                                'rating' => 5,
                                                'product' => 'Enterprise Solution',
                                                'date' => '2024-01-13',
                                                'status' => 'Published',
                                                'status_class' => 'success',
                                                'helpful' => 15
                                            ],
                                            [
                                                'customer' => 'Nasrin Akter',
                                                'email' => 'sarah@example.com',
                                                'review' => 'The product works as advertised, but I\'m waiting for a response to my feature request from last week.',
                                                'rating' => 4,
                                                'product' => 'Software License',
                                                'date' => '2024-01-12',
                                                'status' => 'Pending',
                                                'status_class' => 'warning',
                                                'helpful' => 3
                                            ],
                                            [
                                                'customer' => 'Karim Mia',
                                                'email' => 'tom@example.com',
                                                'review' => 'Very disappointed with the recent update. It broke several features I rely on. Please fix this urgently.',
                                                'rating' => 1,
                                                'product' => 'Mobile App',
                                                'date' => '2024-01-11',
                                                'status' => 'Flagged',
                                                'status_class' => 'danger',
                                                'helpful' => 6
                                            ],
                                            [
                                                'customer' => 'Rina Sultana',
                                                'email' => 'lisa@example.com',
                                                'review' => 'Great value for money! The quality exceeded my expectations and the delivery was prompt.',
                                                'rating' => 5,
                                                'product' => 'Starter Package',
                                                'date' => '2024-01-10',
                                                'status' => 'Published',
                                                'status_class' => 'success',
                                                'helpful' => 9
                                            ],
                                        ];
                                    @endphp
                                    @foreach($customerReviews as $review)
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
                                                    <small class="text-muted">{{ $review['email'] }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-3 py-3">
                                            <div class="review-text">
                                                {{ Str::limit($review['review'], 100) }}
                                                @if(strlen($review['review']) > 100)
                                                    <a href="#" class="text-primary ms-1" onclick="return false;">Read more</a>
                                                @endif
                                            </div>
                                            <small class="text-muted">{{ $review['helpful'] }} people found this helpful</small>
                                        </td>
                                        <td class="px-3 py-3">
                                            <div class="d-flex align-items-center">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $review['rating'] ? 'text-warning' : 'text-muted' }} me-1" style="font-size: 12px;"></i>
                                                @endfor
                                                <span class="ms-2 fw-bold">{{ $review['rating'] }}</span>
                                            </div>
                                        </td>
                                        <td class="px-3 py-3">
                                            <span class="badge bg-info">{{ $review['product'] }}</span>
                                        </td>
                                        <td class="px-3 py-3">{{ $review['date'] }}</td>
                                        <td class="px-3 py-3">
                                            <span class="badge bg-{{ $review['status_class'] }}">{{ $review['status'] }}</span>
                                        </td>
                                        <td class="px-3 py-3 text-center">
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-outline-info" title="View Full Review">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-outline-success" title="Publish">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button class="btn btn-outline-primary" title="Reply to Customer">
                                                    <i class="fas fa-reply"></i>
                                                </button>
                                                <button class="btn btn-outline-warning" title="Flag Review">
                                                    <i class="fas fa-flag"></i>
                                                </button>
                                                <button class="btn btn-outline-danger" title="Hide Review">
                                                    <i class="fas fa-eye-slash"></i>
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
                                Showing 1 to 6 of 247 customer reviews
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

                        <!-- Review Response Templates -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="card-title text-success">
                                            <i class="fas fa-thumbs-up me-2"></i>Positive Review Response
                                        </h6>
                                        <p class="card-text small text-muted mb-2">Thank you for your wonderful feedback! We're delighted to hear about your positive experience.</p>
                                        <button class="btn btn-sm btn-outline-success">Use Template</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="card-title text-warning">
                                            <i class="fas fa-balance-scale me-2"></i>Neutral Review Response
                                        </h6>
                                        <p class="card-text small text-muted mb-2">Thank you for your feedback. We appreciate you taking the time to share your experience with us.</p>
                                        <button class="btn btn-sm btn-outline-warning">Use Template</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="card-title text-danger">
                                            <i class="fas fa-exclamation-triangle me-2"></i>Negative Review Response
                                        </h6>
                                        <p class="card-text small text-muted mb-2">We're sorry to hear about your experience. Your feedback is important to us and we'll work to improve.</p>
                                        <button class="btn btn-sm btn-outline-danger">Use Template</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="card-title text-info">
                                            <i class="fas fa-clock me-2"></i>Delayed Response
                                        </h6>
                                        <p class="card-text small text-muted mb-2">Thank you for your patience. We're currently investigating this issue and will update you soon.</p>
                                        <button class="btn btn-sm btn-outline-info">Use Template</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                            <h4 class="text-primary mb-3">Comprehensive Review System</h4>
                            <p class="text-muted mb-4">Advanced review analytics, moderation tools, response management, and customer engagement features coming soon.</p>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.customers.index') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-users me-2"></i>All Customers
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
    .badge-warning {
        background-color: #ffc107;
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

<!-- Bulk Response Modal -->
<div class="modal fade" id="bulkResponseModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bulk Response to Reviews</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Select Reviews to Respond To</label>
                    <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                        <div class="form-check mb-2">
                            <input class="form-check-input bulk-review-checkbox" type="checkbox" value="1" id="review1">
                            <label class="form-check-label" for="review1">
                                <strong>Mohammad Ali</strong> - 5★ - "Excellent customer service!"
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input bulk-review-checkbox" type="checkbox" value="2" id="review2">
                            <label class="form-check-label" for="review2">
                                <strong>Fatema Begum</strong> - 3★ - "Good product, needs improvement"
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input bulk-review-checkbox" type="checkbox" value="3" id="review3">
                            <label class="form-check-label" for="review3">
                                <strong>Rahim Hossain</strong> - 5★ - "Outstanding experience!"
                            </label>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Response Template</label>
                    <select class="form-control" id="responseTemplate">
                        <option>Thank You Response</option>
                        <option>Improvement Acknowledgment</option>
                        <option>Issue Resolution Update</option>
                        <option>Custom Response</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Response Message</label>
                    <textarea class="form-control" rows="4" id="bulkResponseMessage" placeholder="Enter your response message...">Thank you for your valuable feedback! We appreciate you taking the time to share your experience with us. Your input helps us improve our services for everyone.</textarea>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="sendEmailNotification" checked>
                        <label class="form-check-label" for="sendEmailNotification">
                            Send email notification to customers
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="sendBulkResponse">Send Responses</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Handle template selection
    $('#responseTemplate').on('change', function() {
        const template = $(this).val();
        let message = '';

        switch(template) {
            case 'Thank You Response':
                message = 'Thank you for your valuable feedback! We appreciate you taking the time to share your experience with us. Your input helps us improve our services for everyone.';
                break;
            case 'Improvement Acknowledgment':
                message = 'Thank you for your feedback. We\'re constantly working to improve our services and appreciate your suggestions for making us better.';
                break;
            case 'Issue Resolution Update':
                message = 'Thank you for bringing this to our attention. We\'ve identified the issue and are working on a resolution. We\'ll update you as soon as possible.';
                break;
            case 'Custom Response':
                message = '';
                break;
        }

        $('#bulkResponseMessage').val(message);
    });

    // Send bulk response
    $('#sendBulkResponse').on('click', function() {
        const selectedReviews = $('.bulk-review-checkbox:checked').length;
        const message = $('#bulkResponseMessage').val();

        if (selectedReviews === 0) {
            alert('Please select at least one review to respond to.');
            return;
        }

        if (!message.trim()) {
            alert('Please enter a response message.');
            return;
        }

        // Simulate sending responses
        alert(`Sending responses to ${selectedReviews} review(s)...`);
        $('#bulkResponseModal').modal('hide');

        // Reset form
        $('.bulk-review-checkbox').prop('checked', false);
        $('#bulkResponseMessage').val('');
    });

    // Review actions
    $('.btn-outline-success').on('click', function() {
        $(this).removeClass('btn-outline-success').addClass('btn-success').html('<i class="fas fa-check"></i>');
        showNotification('Review published successfully!', 'success');
    });

    $('.btn-outline-warning').on('click', function() {
        $(this).removeClass('btn-outline-warning').addClass('btn-warning').html('<i class="fas fa-flag"></i>');
        showNotification('Review flagged for review!', 'warning');
    });

    $('.btn-outline-danger').on('click', function() {
        if (confirm('Are you sure you want to hide this review?')) {
            $(this).closest('tr').fadeOut();
            showNotification('Review hidden successfully!', 'info');
        }
    });

    function showNotification(message, type) {
        // Simple notification - in real app, use a proper notification system
        const notification = $(`<div class="alert alert-${type} alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 9999;">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>`);

        $('body').append(notification);
        setTimeout(() => notification.alert('close'), 3000);
    }
});
</script>
@endsection