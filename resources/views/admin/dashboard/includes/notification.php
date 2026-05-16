@php
$notifications = \App\Models\Notification::where('user_id', auth()->id())
    ->latest()
    ->limit(10)
    ->get();
$unreadCount = \App\Models\Notification::where('user_id', auth()->id())
    ->where('is_read', 0)
    ->count();
@endphp

<li class="dropdown notification-dropdown">
    <a class="nav-link dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-bell"></i>
        @if($unreadCount > 0)
            <span class="badge badge-danger">{{ $unreadCount }}</span>
        @endif
    </a>

    <div class="dropdown-menu dropdown-menu-right p-2" style="width:350px;">
        <h6 class="dropdown-header">Notifications</h6>

        <div class="list-group">
            @forelse($notifications as $note)
                <a href="{{ $note->link ?? '#' }}"
                   class="list-group-item list-group-item-action">
                    <div class="d-flex justify-content-between mb-1">
                        <strong>{{ $note->title }}</strong>
                        <small>{{ $note->created_at->diffForHumans() }}</small>
                    </div>
                    @if($note->message)
                        <p class="mb-0 text-muted" style="font-size: 13px;">
                            {{ $note->message }}
                        </p>
                    @endif
                </a>
            @empty
                <p class="text-center text-muted m-2">No notifications</p>
            @endforelse
        </div>

        <div class="dropdown-divider"></div>
        <a href="{{ route('admin.notifications.all') }}" class="dropdown-item text-center">
            View All
        </a>
    </div>
</li>
