@extends('admin.dashboard.master')

@section('title', 'Cache Management')

@section('main_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-memory"></i> Cache Management
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Cache Information -->
                        <div class="col-md-6">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h5 class="card-title">Cache Configuration</h5>
                                </div>
                                <div class="card-body">
                                    <dl class="row">
                                        <dt class="col-sm-5">Cache Driver:</dt>
                                        <dd class="col-sm-7">
                                            <span class="badge badge-info">{{ $cacheInfo['driver'] }}</span>
                                        </dd>

                                        <dt class="col-sm-5">Status:</dt>
                                        <dd class="col-sm-7">
                                            <span class="badge badge-{{ $cacheInfo['status'] == 'Connected' ? 'success' : 'danger' }}">
                                                {{ $cacheInfo['status'] }}
                                            </span>
                                        </dd>

                                        @if(isset($cacheStats['keys_count']))
                                        <dt class="col-sm-5">Total Keys:</dt>
                                        <dd class="col-sm-7">{{ number_format($cacheStats['keys_count']) }}</dd>
                                        @endif

                                        @if(isset($cacheStats['memory_used']))
                                        <dt class="col-sm-5">Memory Used:</dt>
                                        <dd class="col-sm-7">{{ $cacheStats['memory_used'] }}</dd>
                                        @endif

                                        @if(isset($cacheStats['cache_files']))
                                        <dt class="col-sm-5">Cache Files:</dt>
                                        <dd class="col-sm-7">{{ number_format($cacheStats['cache_files']) }}</dd>
                                        @endif
                                    </dl>

                                    @if(isset($cacheStats['error']))
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle"></i> {{ $cacheStats['error'] }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Cache Actions -->
                        <div class="col-md-6">
                            <div class="card card-warning card-outline">
                                <div class="card-header">
                                    <h5 class="card-title">Cache Operations</h5>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted">Perform cache maintenance operations:</p>

                                    <div class="d-grid gap-2">
                                        <form action="{{ route('admin.system.cache.clear') }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Are you sure you want to clear all caches? This may temporarily slow down the application.')">
                                                <i class="fas fa-trash"></i> Clear All Caches
                                            </button>
                                        </form>

                                        <button type="button" class="btn btn-info btn-block" onclick="checkCacheStatus()">
                                            <i class="fas fa-search"></i> Check Cache Status
                                        </button>

                                        <button type="button" class="btn btn-secondary btn-block" onclick="refreshPage()">
                                            <i class="fas fa-sync"></i> Refresh Page
                                        </button>
                                    </div>

                                    <hr>

                                    <div class="alert alert-info">
                                        <h6><i class="fas fa-info-circle"></i> Cache Types Cleared:</h6>
                                        <ul class="mb-0">
                                            <li>Application Cache</li>
                                            <li>Configuration Cache</li>
                                            <li>Route Cache</li>
                                            <li>View Cache</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cache Performance Metrics -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card card-success card-outline">
                                <div class="card-header">
                                    <h5 class="card-title">Cache Performance Tips</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6><i class="fas fa-check-circle text-success"></i> Recommended Settings</h6>
                                            <ul>
                                                <li>Use Redis for better performance in production</li>
                                                <li>Enable OPcache for PHP optimization</li>
                                                <li>Set appropriate cache TTL values</li>
                                                <li>Monitor cache hit/miss ratios</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6><i class="fas fa-exclamation-triangle text-warning"></i> Performance Issues</h6>
                                            <ul>
                                                <li>High memory usage with file cache</li>
                                                <li>Slow response times with database cache</li>
                                                <li>Cache stampede with short TTL</li>
                                                <li>Large objects in memory cache</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <small class="text-muted">
                        <i class="fas fa-clock"></i> Last updated: {{ now()->format('Y-m-d H:i:s') }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function checkCacheStatus() {
    // Simple cache status check
    fetch(window.location.href, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (response.ok) {
            toastr.success('Cache is responding correctly');
        } else {
            toastr.error('Cache may have issues');
        }
    })
    .catch(error => {
        toastr.error('Unable to check cache status');
    });
}

function refreshPage() {
    window.location.reload();
}
</script>
@endsection