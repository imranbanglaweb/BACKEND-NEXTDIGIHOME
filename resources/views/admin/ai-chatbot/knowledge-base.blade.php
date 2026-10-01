@extends('admin.dashboard.master')

@section('title', 'AI Knowledge Base & RAG Training - ' . config('app.name'))

@section('main_content')
@include('admin.partials.premium-ui')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    .ai-root {
        font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
        color: #0f172a;
    }
    .nav-tabs-ai {
        display: flex;
        gap: 8px;
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 20px;
    }
    .nav-tabs-ai a {
        padding: 9px 16px;
        font-size: 13.5px;
        font-weight: 600;
        color: #64748b;
        text-decoration: none;
        border-radius: 8px 8px 0 0;
        border-bottom: 2px solid transparent;
        transition: all 0.2s;
    }
    .nav-tabs-ai a:hover { color: #0f172a; }
    .nav-tabs-ai a.active {
        color: #00b894;
        border-bottom-color: #00b894;
        background: rgba(0, 212, 170, 0.05);
    }
    .table-ai {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    .table-ai th {
        background: #f8fafc;
        font-size: 12px;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 13px 16px;
        border-bottom: 1px solid #e2e8f0;
    }
    .table-ai td {
        padding: 13px 16px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13.5px;
        vertical-align: middle;
    }
    .table-ai tr:hover td {
        background: #fbfcfe;
    }
    .category-badge {
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .cat-software_catalog { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
    .cat-solutions { background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; }
    .cat-pricing { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }
    .cat-company { background: #faf5ff; color: #6b21a8; border: 1px solid #e9d5ff; }
    .cat-general { background: #f1f5f9; color: #334155; border: 1px solid #cbd5e1; }
</style>

<div class="ai-root">
    <!-- Header -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0;">Knowledge Base & Dynamic RAG Chunks</h1>
            <p style="font-size: 13.5px; color: #64748b; margin: 3px 0 0;">Manage Q&A, products, ERP catalogs, pricing guides and contextual knowledge retrieved by the AI agent.</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <form action="{{ route('admin.ai-chatbot.knowledge-base.sync-defaults') }}" method="POST" onsubmit="return confirm('Sync standard software & service catalog? This will update existing default items.');">
                @csrf
                <button type="submit" class="btn btn-outline-secondary" style="font-size: 13px; font-weight: 600; border-radius: 8px;">
                    <i class="fa fa-sync-alt me-1"></i> Sync Default Catalog
                </button>
            </form>
            <a href="{{ route('admin.ai-chatbot.knowledge-base.create') }}" class="btn btn-primary" style="font-size: 13px; font-weight: 600; border-radius: 8px; background: #00d4aa; border-color: #00d4aa; color: #000;">
                <i class="fa fa-plus me-1"></i> Add Knowledge Chunk
            </a>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="nav-tabs-ai">
        <a href="{{ route('admin.ai-chatbot.dashboard') }}"><i class="fa fa-chart-pie me-1"></i> Analytics Dashboard</a>
        <a href="{{ route('admin.ai-chatbot.conversations') }}"><i class="fa fa-comments me-1"></i> Conversation Logs</a>
        <a href="{{ route('admin.ai-chatbot.knowledge-base') }}" class="active"><i class="fa fa-brain me-1"></i> Knowledge Base & RAG</a>
        <a href="{{ route('admin.ai-chatbot.leads') }}"><i class="fa fa-user-check me-1"></i> Captured Leads</a>
        <a href="{{ route('admin.ai-chatbot.settings') }}"><i class="fa fa-sliders-h me-1"></i> Configuration</a>
        <a href="{{ route('admin.ai-chatbot.playground') }}"><i class="fa fa-terminal me-1"></i> Test Playground</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 10px;">
        <i class="fa fa-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Filter Bar -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px 20px; margin-bottom: 20px;">
        <form method="GET" action="{{ route('admin.ai-chatbot.knowledge-base') }}" class="row g-2 align-items-center">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search title, keywords, or content..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select name="category" class="form-select form-select-sm">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                            {{ ucwords(str_replace('_', ' ', $cat)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary w-100" style="border-radius: 6px;">Filter</button>
                <a href="{{ route('admin.ai-chatbot.knowledge-base') }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 6px;">Reset</a>
            </div>
        </form>
    </div>

    <!-- Knowledge Table -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);">
        <div class="table-responsive">
            <table class="table-ai">
                <thead>
                    <tr>
                        <th style="width: 35%;">Title & Keywords</th>
                        <th>Category</th>
                        <th>Priority</th>
                        <th>RAG Hits</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr>
                        <td>
                            <div style="font-weight: 700; color: #0f172a; margin-bottom: 2px;">
                                {{ $item->title }}
                            </div>
                            <div style="font-family: 'JetBrains Mono', monospace; font-size: 11px; color: #64748b; line-height: 1.3;">
                                {{ \Illuminate\Support\Str::limit($item->keywords, 65) }}
                            </div>
                        </td>
                        <td>
                            @php $catClass = 'cat-' . ($item->category ?? 'general'); @endphp
                            <span class="category-badge {{ $catClass }}">
                                {{ str_replace('_', ' ', $item->category) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $item->priority >= 9 ? 'bg-success' : 'bg-secondary' }}" style="font-size: 11px;">
                                P{{ $item->priority }}
                            </span>
                        </td>
                        <td style="font-weight: 800; color: #0284c7;">
                            {{ number_format($item->hit_count) }}
                        </td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="toggle-{{ $item->id }}" {{ $item->is_active ? 'checked' : '' }} onchange="toggleKnowledgeActive({{ $item->id }})">
                                <label class="form-check-label" for="toggle-{{ $item->id }}" style="font-size: 12px; color: #64748b;">
                                    {{ $item->is_active ? 'Active' : 'Draft' }}
                                </label>
                            </div>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.ai-chatbot.knowledge-base.edit', $item->id) }}" class="btn btn-sm btn-outline-primary me-1" style="border-radius: 6px; padding: 4px 10px; font-size: 12px;">
                                <i class="fa fa-edit me-1"></i> Edit
                            </a>
                            <form action="{{ route('admin.ai-chatbot.knowledge-base.destroy', $item->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Delete this knowledge item?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius: 6px; padding: 4px 8px; font-size: 12px;">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No knowledge chunks found. Click "Sync Default Catalog" or "Add Knowledge Chunk" to get started.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding: 15px 20px; border-top: 1px solid #f1f5f9;">
            {{ $items->links() }}
        </div>
    </div>
</div>

<script>
function toggleKnowledgeActive(id) {
    fetch('{{ url("admin/ai-chatbot/knowledge-base") }}/' + id + '/toggle-active', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (!data.success) {
            alert('Failed to toggle status');
        }
    })
    .catch(err => alert('Error: ' + err.message));
}
</script>
@endsection
