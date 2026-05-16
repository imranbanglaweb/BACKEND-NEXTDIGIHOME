@extends('admin.dashboard.master')

@section('title', 'System Information')

@section('main_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i> System Information
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- System Information -->
                        <div class="col-md-6">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h5 class="card-title">Application Information</h5>
                                </div>
                                <div class="card-body">
                                    <dl class="row">
                                        <dt class="col-sm-5">PHP Version:</dt>
                                        <dd class="col-sm-7">{{ $systemInfo['php_version'] }}</dd>

                                        <dt class="col-sm-5">Laravel Version:</dt>
                                        <dd class="col-sm-7">{{ $systemInfo['laravel_version'] }}</dd>

                                        <dt class="col-sm-5">Environment:</dt>
                                        <dd class="col-sm-7">
                                            <span class="badge badge-{{ $systemInfo['environment'] == 'production' ? 'danger' : 'info' }}">
                                                {{ $systemInfo['environment'] }}
                                            </span>
                                        </dd>

                                        <dt class="col-sm-5">Debug Mode:</dt>
                                        <dd class="col-sm-7">
                                            <span class="badge badge-{{ $systemInfo['debug_mode'] == 'Enabled' ? 'warning' : 'success' }}">
                                                {{ $systemInfo['debug_mode'] }}
                                            </span>
                                        </dd>

                                        <dt class="col-sm-5">Maintenance Mode:</dt>
                                        <dd class="col-sm-7">
                                            <span class="badge badge-{{ $systemInfo['maintenance_mode'] == 'Enabled' ? 'danger' : 'success' }}">
                                                {{ $systemInfo['maintenance_mode'] }}
                                            </span>
                                        </dd>

                                        <dt class="col-sm-5">Timezone:</dt>
                                        <dd class="col-sm-7">{{ $systemInfo['timezone'] }}</dd>

                                        <dt class="col-sm-5">Locale:</dt>
                                        <dd class="col-sm-7">{{ $systemInfo['locale'] }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <!-- Server Information -->
                        <div class="col-md-6">
                            <div class="card card-success card-outline">
                                <div class="card-header">
                                    <h5 class="card-title">Server Information</h5>
                                </div>
                                <div class="card-body">
                                    <dl class="row">
                                        <dt class="col-sm-5">Server Software:</dt>
                                        <dd class="col-sm-7">{{ $systemInfo['server_software'] }}</dd>

                                        <dt class="col-sm-5">Database:</dt>
                                        <dd class="col-sm-7">{{ $databaseInfo['database_name'] }}</dd>

                                        <dt class="col-sm-5">DB Connection:</dt>
                                        <dd class="col-sm-7">
                                            <span class="badge badge-{{ $databaseInfo['connection_status'] == 'Connected' ? 'success' : 'danger' }}">
                                                {{ $databaseInfo['connection_status'] }}
                                            </span>
                                        </dd>

                                        <dt class="col-sm-5">Cache Driver:</dt>
                                        <dd class="col-sm-7">{{ $systemInfo['cache_driver'] }}</dd>

                                        <dt class="col-sm-5">Session Driver:</dt>
                                        <dd class="col-sm-7">{{ $systemInfo['session_driver'] }}</dd>

                                        <dt class="col-sm-5">Total Disk Space:</dt>
                                        <dd class="col-sm-7">{{ $diskInfo['total_space'] }}</dd>

                                        <dt class="col-sm-5">Free Disk Space:</dt>
                                        <dd class="col-sm-7">{{ $diskInfo['free_space'] }}</dd>

                                        <dt class="col-sm-5">Used Disk Space:</dt>
                                        <dd class="col-sm-7">{{ $diskInfo['used_space'] }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- System Status -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card card-warning card-outline">
                                <div class="card-header">
                                    <h5 class="card-title">System Status</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-info"><i class="fas fa-server"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Server</span>
                                                    <span class="info-box-number">Online</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-success"><i class="fas fa-database"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Database</span>
                                                    <span class="info-box-number">{{ $databaseInfo['connection_status'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-warning"><i class="fas fa-memory"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Cache</span>
                                                    <span class="info-box-number">{{ $systemInfo['cache_driver'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-danger"><i class="fas fa-shield-alt"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Security</span>
                                                    <span class="info-box-number">{{ $systemInfo['debug_mode'] == 'Disabled' ? 'Secure' : 'Debug' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection