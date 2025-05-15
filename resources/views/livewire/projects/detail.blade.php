<div>
    <div class="main-content">
        <div class="content-header">
            <h2>Project Details</h2>
            <div class="action-buttons">
                <a href="{{ route('projects.index') }}" class="btn btn-secondary">Back to Projects</a>
            </div>
        </div>

        <div class="detail-container">
            <div class="detail-header">
                <h1 class="detail-title">{{ $project->title }}</h1>
                <div class="detail-meta">
                    <div class="meta-item">
                        <span class="meta-label">Created:</span>
                        <span class="meta-value">{{ $project->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Last Updated:</span>
                        <span class="meta-value">{{ $project->updated_at->format('M d, Y') }}</span>
                    </div>
                    @if($project->url)
                    <div class="meta-item">
                        <span class="meta-label">URL:</span>
                        <a href="{{ $project->url }}" target="_blank" class="meta-link">
                            {{ $project->url }} <span class="external-icon">↗</span>
                        </a>
                    </div>
                    @endif
                    <div class="meta-item">
                        <span class="meta-label">Slug:</span>
                        <span class="meta-value">{{ $project->slug }}</span>
                    </div>
                </div>
            </div>

            @if($project->image)
            <div class="detail-image">
                <img src="{{ Storage::url($project->image) }}" alt="{{ $project->title }}">
            </div>
            @endif

            <div class="detail-content">
                <div class="content-section">
                    <h3 class="section-title">Description</h3>
                    <div class="section-content">
                        {!! $project->description !!}
                    </div>
                </div>
            </div>

            <div class="detail-footer">
                <div class="footer-actions">
                    <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-primary">Edit Project</a>
                    <button
                        wire:click="$dispatch('delete-project', { id: {{ $project->id }} })"
                        wire:confirm="Are you sure you want to delete this project?"
                        class="btn btn-danger">
                        Delete Project
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:initialized', function () {
            Livewire.on('delete-project', projectData => {
                // Redirect after delete
                window.location.href = "{{ route('projects.index') }}";
            });
        });
    </script>

    <style>
    .responsive-video {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 aspect ratio */
        height: 0;
        overflow: hidden;
        margin-top: 1rem;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .responsive-video iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 0.5rem;
    }

    .video-container {
        margin-top: 2rem;
    }

    .external-link {
        color: #6366f1;
        text-decoration: none;
    }

    .external-link:hover {
        text-decoration: underline;
    }
    </style>
</div>
