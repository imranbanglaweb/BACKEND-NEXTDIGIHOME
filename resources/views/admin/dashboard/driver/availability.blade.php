@extends('admin.dashboard.master')
@section('main_content')
<style>
    :root {
        --primary-color: #4f46e5;
        --primary-dark: #4338ca;
        --bg-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --card-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }
    
    body { font-family: 'Inter', sans-serif; }
    
        .page-header {
    background: #fff;
    padding: 0 25px;
    border-bottom: 1px solid var(--border-color);
    /* margin-bottom: 20px; */
    background-color:#000
}
    
    .page-header h2 {
        color: white;
        margin: 0;
        font-weight: 700;
        font-size: 22px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .right-wrapper {
        color: white;
    }
    
    .breadcrumbs {
        color: rgba(255,255,255,0.9);
        margin: 0;
        padding: 0;
        list-style: none;
        display: flex;
        gap: 5px;
    }
    
    .breadcrumbs li {
        display: flex;
        align-items: center;
    }
    
    .breadcrumbs li + li::before {
        content: "/";
        margin: 0 8px;
        opacity: 0.7;
    }
    
    .breadcrumbs a {
        color: rgba(255,255,255,0.9);
        text-decoration: none;
        transition: opacity 0.3s ease;
    }
    
    .breadcrumbs a:hover {
        opacity: 1;
    }
    
    .breadcrumbs span {
        color: rgba(255,255,255,0.7);
    }
    
    .card-premium {
        background: white;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
    }
    
    .card-premium .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 25px;
        border: none;
    }
    
    .card-premium .card-body {
        padding: 25px;
    }
    
    .status-option {
        padding: 20px;
        border-radius: 12px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    .status-option:hover {
        transform: translateY(-3px);
    }
    
    .status-option.available {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }
    
    .status-option.busy {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }
    
    .status-option.off-duty {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        color: white;
    }
    
    .status-option.selected {
        border-color: #1e3a5f;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.3);
    }
    
    .status-icon {
        font-size: 36px;
        margin-bottom: 10px;
    }
    
    .status-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 5px;
    }
    
    .status-desc {
        font-size: 13px;
        opacity: 0.9;
    }
    
    .btn-save {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 15px 30px;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.3s ease;
    }
    
    .btn-save:hover {
        transform: translateY(-2px);
    }
    
    .current-status {
        background: #f8fafc;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
    }
    
    .current-status h4 {
        margin: 0 0 10px 0;
        color: #4a5568;
    }
    
    .current-status .status-badge {
        display: inline-block;
        padding: 8px 20px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 14px;
    }
    
    .current-status .status-badge.available {
        background: #10b981;
        color: white;
    }
    
    .current-status .status-badge.busy {
        background: #f59e0b;
        color: white;
    }
    
    .current-status .status-badge.off-duty {
        background: #6b7280;
        color: white;
    }
    
    .alert-info {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 20px 25px;
        font-size: 15px;
    }
</style>


<section role="main" class="content-body">
    <header class="page-header">
        <h2><i class="fa fa-user-clock mr-2"></i>My Availability</h2>
        <div class="right-wrapper">
            <ol class="breadcrumbs">
                <li>
                    <a href="{{ route('home') }}">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Driver Portal</span></li>
                <li><span>My Availability</span></li>
            </ol>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @if(isset($driver))
                <div class="card-premium">
                    <div class="card-header">
                        <h3 class="card-title mb-0"><i class="fa fa-toggle-on mr-2"></i>Update Your Availability Status</h3>
                    </div>
                    <div class="card-body">
                        <div class="current-status">
                            <h4>Current Status:</h4>
                            <span class="status-badge {{ $driver->availability_status ?? 'available' }}">
                                {{ ucfirst($driver->availability_status ?? 'Available') }}
                            </span>
                        </div>
                        
                        <form action="{{ route('driver.availability.update') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="status-option available {{ (isset($driver) && $driver->availability_status == 'available') ? 'selected' : '' }}" onclick="selectStatus('available')">
                                        <div class="status-icon"><i class="fa fa-check-circle"></i></div>
                                        <div class="status-title">Available</div>
                                        <div class="status-desc">Ready for assignments</div>
                                        <input type="radio" name="availability_status" value="available" {{ (isset($driver) && $driver->availability_status == 'available') ? 'checked' : '' }} style="display: none;">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="status-option busy {{ (isset($driver) && $driver->availability_status == 'busy') ? 'selected' : '' }}" onclick="selectStatus('busy')">
                                        <div class="status-icon"><i class="fa fa-clock"></i></div>
                                        <div class="status-title">Busy</div>
                                        <div class="status-desc">Currently on a trip</div>
                                        <input type="radio" name="availability_status" value="busy" {{ (isset($driver) && $driver->availability_status == 'busy') ? 'checked' : '' }} style="display: none;">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="status-option off-duty {{ (isset($driver) && $driver->availability_status == 'off_duty') ? 'selected' : '' }}" onclick="selectStatus('off_duty')">
                                        <div class="status-icon"><i class="fa fa-bed"></i></div>
                                        <div class="status-title">Off Duty</div>
                                        <div class="status-desc">Not available</div>
                                        <input type="radio" name="availability_status" value="off_duty" {{ (isset($driver) && $driver->availability_status == 'off_duty') ? 'checked' : '' }} style="display: none;">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn-save">
                                        <i class="fa fa-save mr-2"></i>Update Status
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @else
                <div class="card-premium">
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle mr-2"></i>
                            Driver profile not found. Please contact administrator.
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<script>
    function selectStatus(status) {
        // Remove selected class from all options
        document.querySelectorAll('.status-option').forEach(option => {
            option.classList.remove('selected');
        });
        
        // Add selected class to clicked option
        event.currentTarget.classList.add('selected');
        
        // Check the radio button
        document.querySelector(`input[value="${status}"]`).checked = true;
    }
</script>
@endsection
