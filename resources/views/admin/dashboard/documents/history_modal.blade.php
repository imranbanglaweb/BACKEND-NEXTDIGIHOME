<div class="modal-header">
    <h5 class="modal-title">Document History</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <div class="timeline">
        @foreach($histories as $history)
        <div class="timeline-item">
            <div class="timeline-marker bg-{{ $history->action === 'withdrawn' ? 'warning' : ($history->action === 'returned' ? 'success' : 'info') }}"></div>
            <div class="timeline-content">
                <h3 class="timeline-title">
                    {{ ucfirst($history->action) }}
                    <small class="text-muted">
                        {{ $history->action_date->format('d M Y h:i A') }}
                    </small>
                </h3>
                <p>{{ $history->details }}</p>
                <p class="text-muted">
                    <small>By: {{ $history->performer->name }}</small>
                </p>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>

<style>
.timeline {
    position: relative;
    padding: 20px 0;
    margin: 0;
}

.timeline-item {
    position: relative;
    padding: 20px 0;
    border-left: 2px solid #dee2e6;
    margin-left: 20px;
}

.timeline-marker {
    position: absolute;
    left: -9px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
}

.timeline-content {
    margin-left: 30px;
    padding: 10px;
    background-color: #f8f9fa;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.timeline-title {
    font-size: 1.65rem;
    margin-bottom: 0.5rem;
    font-weight: bold;
}

.timeline-title small {
    margin-left: 10px;
    font-size: 0.999rem;
    color: brown;
    font-weight: bold;
}
.timeline-title p {
    margin-left: 10px;
    font-size: 0.999rem!important;
    color: brown!important;
    font-weight: bold;
}

.modal-header {
    background-color: #343a40;
    color: #fff;
    border-bottom: 1px solid #dee2e6;
}

.modal-title {
    font-size: 1.5rem;
    font-weight: bold;
}

.modal-body {
    font-size: 1rem;
}

.modal-footer {
    background-color: #f8f9fa;
    border-top: 1px solid #dee2e6;
}

.text-muted {
    font-size: 15px!important;
    color: orange!important;
}
</style>