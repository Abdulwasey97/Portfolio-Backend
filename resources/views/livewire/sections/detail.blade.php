<div class="detail-container">
    <div class="detail-header">
        <div class="breadcrumbs">
            @if($section->page_id)
                <a href="{{ route('pages.index') }}" class="breadcrumb-link">Pages</a>
                <span class="breadcrumb-separator">/</span>
                <a href="{{ route('sections.index', ['page_id' => $section->page_id]) }}" class="breadcrumb-link">
                    {{ $section->page->title }} Sections
                </a>
            @elseif($section->project_id)
                <a href="{{ route('projects.index') }}" class="breadcrumb-link">Projects</a>
                <span class="breadcrumb-separator">/</span>
                <a href="{{ route('sections.index', ['project_id' => $section->project_id]) }}" class="breadcrumb-link">
                    {{ $section->project->title }} Sections
                </a>
            @endif
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current">{{ $section->title }}</span>
        </div>

        <div class="detail-actions">
            <a href="{{ route('sections.edit', $section->id) }}" class="action-button secondary-action">
                <span class="action-icon">✏️</span> Edit Section
            </a>
            @if($section->page_id)
                <a href="{{ route('pages.detail', $section->page_id) }}" class="action-button primary-action">
                    <span class="action-icon">📄</span> View Page
                </a>
            @elseif($section->project_id)
                <a href="{{ route('projects.detail', $section->project_id) }}" class="action-button primary-action">
                    <span class="action-icon">📄</span> View Project
                </a>
            @endif
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-content">
            @if($section->image)
                <div class="section-hero">
                    <div class="section-featured-image">
                        <img src="{{ Storage::url($section->image) }}" alt="{{ $section->title }}">
                    </div>
                    <div class="image-overlay">
                        <h1 class="overlay-title">{{ $section->title }}</h1>
                        <span class="status-badge {{ $section->status === 'published' ? 'status-published' : 'status-draft' }}">
                            {{ $section->status }}
                        </span>
                    </div>
                </div>

                <div class="image-tools">
                    <a href="{{ Storage::url($section->image) }}" target="_blank" class="image-tool-button">
                        <span class="tool-icon">↗️</span> Open Original
                    </a>
                    <button id="fullscreen-toggle" class="image-tool-button">
                        <span class="tool-icon">🔍</span> View Fullscreen
                    </button>
                </div>

                <!-- Fullscreen image viewer -->
                <div id="fullscreen-viewer" class="fullscreen-image">
                    <button id="close-fullscreen" class="close-fullscreen">×</button>
                    <img src="{{ Storage::url($section->image) }}" alt="{{ $section->title }}">
                </div>
            @else
                <div class="section-header">
                    <h1 class="section-title">{{ $section->title }}</h1>
                    <span class="status-badge {{ $section->status === 'published' ? 'status-published' : 'status-draft' }}">
                        {{ $section->status }}
                    </span>
                </div>
            @endif

            <div class="section-meta">
                <div class="meta-item">
                    <span class="meta-label">Order</span>
                    <span class="meta-value">#{{ $section->order }}</span>
                </div>
                @if($section->page_id)
                <div class="meta-item">
                    <span class="meta-label">Page</span>
                    <span class="meta-value">
                        <a href="{{ route('pages.detail', $section->page_id) }}" class="meta-link">
                            {{ $section->page->title }}
                        </a>
                    </span>
                </div>
                @elseif($section->project_id)
                <div class="meta-item">
                    <span class="meta-label">Project</span>
                    <span class="meta-value">
                        <a href="{{ route('projects.detail', $section->project_id) }}" class="meta-link">
                            {{ $section->project->title }}
                        </a>
                    </span>
                </div>
                @endif
                <div class="meta-item">
                    <span class="meta-label">Created</span>
                    <span class="meta-value">{{ $section->created_at->format('M d, Y h:i A') }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Last Updated</span>
                    <span class="meta-value">{{ $section->updated_at->format('M d, Y h:i A') }}</span>
                </div>
            </div>

            <div class="section-content-container">
                <h2 class="content-title">Content</h2>
                <div class="content-body">
                    {!! nl2br(e($section->content)) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="section-navigation">
        @php
            if ($section->page_id) {
                $prevSection = \App\Models\Section::where('page_id', $section->page_id)
                    ->where('order', '<', $section->order)
                    ->orderBy('order', 'desc')
                    ->first();

                $nextSection = \App\Models\Section::where('page_id', $section->page_id)
                    ->where('order', '>', $section->order)
                    ->orderBy('order', 'asc')
                    ->first();
            } elseif ($section->project_id) {
                $prevSection = \App\Models\Section::where('project_id', $section->project_id)
                    ->where('order', '<', $section->order)
                    ->orderBy('order', 'desc')
                    ->first();

                $nextSection = \App\Models\Section::where('project_id', $section->project_id)
                    ->where('order', '>', $section->order)
                    ->orderBy('order', 'asc')
                    ->first();
            } else {
                $prevSection = null;
                $nextSection = null;
            }
        @endphp

        <div class="nav-links">
            @if($prevSection)
                <a href="{{ route('sections.detail', $prevSection->id) }}" class="nav-prev">
                    <span class="nav-arrow">←</span>
                    <div class="nav-content">
                        <span class="nav-label">Previous Section</span>
                        <span class="nav-title">{{ $prevSection->title }}</span>
                    </div>
                </a>
            @else
                <div class="nav-prev disabled">
                    <span class="nav-arrow">←</span>
                    <div class="nav-content">
                        <span class="nav-label">Previous Section</span>
                        <span class="nav-title">None</span>
                    </div>
                </div>
            @endif

            @if($nextSection)
                <a href="{{ route('sections.detail', $nextSection->id) }}" class="nav-next">
                    <div class="nav-content">
                        <span class="nav-label">Next Section</span>
                        <span class="nav-title">{{ $nextSection->title }}</span>
                    </div>
                    <span class="nav-arrow">→</span>
                </a>
            @else
                <div class="nav-next disabled">
                    <div class="nav-content">
                        <span class="nav-label">Next Section</span>
                        <span class="nav-title">None</span>
                    </div>
                    <span class="nav-arrow">→</span>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fullscreenToggle = document.getElementById('fullscreen-toggle');
        const fullscreenViewer = document.getElementById('fullscreen-viewer');
        const closeFullscreen = document.getElementById('close-fullscreen');

        if (fullscreenToggle && fullscreenViewer && closeFullscreen) {
            fullscreenToggle.addEventListener('click', function() {
                fullscreenViewer.classList.add('active');
                document.body.style.overflow = 'hidden';
            });

            closeFullscreen.addEventListener('click', function() {
                fullscreenViewer.classList.remove('active');
                document.body.style.overflow = '';
            });

            // Also close when clicking outside the image
            fullscreenViewer.addEventListener('click', function(e) {
                if (e.target === fullscreenViewer) {
                    fullscreenViewer.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        }
    });
</script>
@endpush
