@extends('admin.dashboard.master')

@section('main_content')

<div class="container">
    <h4 class="mb-3">All Notifications</h4>

    <div class="card">
        <div class="card-body p-0">
            <ul class="list-group list-group-flush">
                @foreach($notifications as $note)
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $note->title }}</strong>
                            <small>{{ $note->created_at->format('d M Y, h:i A') }}</small>
                        </div>
                        @if($note->message)
                        <p class="mb-1 text-muted">{{ $note->message }}</p>
                        @endif

                        @if($note->link)
                            <a href="{{ $note->link }}" class="btn btn-sm btn-primary">View</a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="card-footer">
            {{ $notifications->links() }}
        </div>
    </div>
</div>

@endsection
