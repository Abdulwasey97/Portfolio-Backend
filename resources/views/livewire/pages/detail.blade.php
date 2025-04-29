<div class="detail-container">
    <div class="detail-header">
        <div class="breadcrumbs">
            <a href="{{ route('pages.index') }}" class="breadcrumb-link">Pages</a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current">{{ $page->title }}</span>
        </div>

        <div class="detail-actions">
            <a href="{{ route('sections.create', ['page_id' => $page->id]) }}" class="action-button primary-action">
                <span class="action-icon">+</span> Add Section
            </a>
            <a href="{{ route('pages.edit', $page->id) }}" class="action-button secondary-action">
                <span class="action-icon">✏️</span> Edit Page
            </a>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-content">
            <div class="detail-main">
                <div class="page-header">
                    <h1 class="page-title">{{ $page->title }}</h1>
                    <span class="status-badge {{ $page->status === 'published' ? 'status-published' : 'status-draft' }}">
                        {{ $page->status }}
                    </span>
                </div>

                @if($page->image)
                    <div class="page-hero">
                        <div class="page-featured-image">
                            <img src="{{ Storage::url($page->image) }}" alt="{{ $page->title }}">
                        </div>
                        <div class="image-overlay">
                            {{-- <h1 class="overlay-title">{{ $page->title }}</h1> --}}
                            <span class="status-badge {{ $page->status === 'published' ? 'status-published' : 'status-draft' }}">
                                {{ $page->status }}
                            </span>
                        </div>
                    </div>
                @else
                    <div class="page-header">
                        <h1 class="page-title">{{ $page->title }}</h1>
                        <span class="status-badge {{ $page->status === 'published' ? 'status-published' : 'status-draft' }}">
                            {{ $page->status }}
                        </span>
                    </div>
                @endif

                @if($page->image)
                    <div class="image-tools">
                        <a href="{{ Storage::url($page->image) }}" target="_blank" class="image-tool-button">
                            <span class="tool-icon">↗️</span> Open Original
                        </a>

                    </div>
                @endif

                <div class="page-meta">
                    <div class="meta-item">
                        <span class="meta-label">URL Slug:</span>
                        <span class="meta-value">{{ $page->slug }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Created:</span>
                        <span class="meta-value">{{ $page->created_at->format('M d, Y h:i A') }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Last Updated:</span>
                        <span class="meta-value">{{ $page->updated_at->format('M d, Y h:i A') }}</span>
                    </div>
                </div>

                @if($page->description)
                    <div class="page-description">
                        <h2 class="section-title">Description</h2>
                        <div class="description-content">
                            {{ $page->description }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="sections-container">
        <div class="sections-header">
            <h2 class="sections-title">Sections ({{ $page->sections->count() }})</h2>
            <a href="{{ route('sections.create', ['page_id' => $page->id]) }}" class="add-section-button">
                <span class="button-icon">+</span> Add Section
            </a>
        </div>

        @if($page->sections->count() > 0)
            <div class="sections-list">
                @foreach($page->sections->sortBy('order') as $section)
                    <div class="section-card">
                        <div class="section-header">
                            <div class="section-order">#{{ $section->order }}</div>
                            <a href="{{ route('sections.detail', $section->id) }}" class="section-title-link">
                                <h3 class="section-title">{{ $section->title }}</h3>
                            </a>
                            <span class="status-badge {{ $section->status === 'published' ? 'status-published' : 'status-draft' }}">
                                {{ $section->status }}
                            </span>
                        </div>

                        @if($section->image)
                            <a href="{{ route('sections.detail', $section->id) }}" class="section-image-link">
                                <div class="section-image">
                                    <img src="{{ Storage::url($section->image) }}" alt="{{ $section->title }}">
                                </div>
                            </a>
                        @endif

                        <div class="section-content">
                            {{ Str::limit($section->content, 200) }}
                        </div>
                        <div class="section-actions">
                            <a href="{{ route('sections.detail', $section->id) }}" class="section-action-button view-button">
                                <span class="action-icon">👁️</span> View
                            </a>
                            <a href="{{ route('sections.edit', $section->id) }}" class="section-action-button">
                                <span class="action-icon">✏️</span> Edit
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-sections">
                <div class="empty-icon">📑</div>
                <h3>No sections yet</h3>
                <p>This page doesn't have any sections. Add a section to get started.</p>
                <a href="{{ route('sections.create', ['page_id' => $page->id]) }}" class="empty-action">
                    Add First Section
                </a>
            </div>
        @endif
    </div>
</div>
