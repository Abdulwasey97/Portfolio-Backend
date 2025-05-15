<div class="table-container">
    <div class="table-header">
        <h1 class="table-title">Projects</h1>
        <div class="header-actions">
            <a href="{{ route('projects.create') }}" class="create-button">
                <span class="create-icon">+</span>
                Create New Project
            </a>
        </div>
    </div>

    <div class="search-container">
        <div class="search-wrapper">
            <span class="search-icon">🔍</span>
            <input type="text" wire:model.live="search" placeholder="Search projects by title or description..."
                  class="search-input">
            @if($search)
                <button wire:click="$set('search', '')" class="clear-button">×</button>
            @endif
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">
            <span class="alert-icon">✓</span>
            <p>{{ session('message') }}</p>
        </div>
    @endif

    <!-- Delete confirmation modal using Livewire -->
    @if($showDeleteModal)
        <div class="delete-modal-backdrop">
            <div class="delete-modal-content">
                <div class="modal-icon">🗑️</div>
                <h3 class="modal-title">Confirm Deletion</h3>
                <p class="modal-message">Are you sure you want to delete this project? This action cannot be undone.</p>
                <div class="modal-actions">
                    <button wire:click="cancelDelete" class="modal-btn cancel-btn">Cancel</button>
                    <button wire:click="deleteProject" class="modal-btn delete-btn">Delete</button>
                </div>
            </div>
        </div>
    @endif

    <div class="data-table">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>URL</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th class="actions-column">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($projects as $project)
                    <tr>
                        <td class="title-cell">
                            <a href="{{ route('projects.detail', $project->id) }}" class="section-title-link">
                                <div class="section-info">
                                    @if($project->image)
                                        <div class="section-thumbnail">
                                            <img src="{{ Storage::url($project->image) }}" alt="{{ $project->title }}">
                                        </div>
                                    @endif
                                    <span>{{ $project->title }}</span>
                                </div>
                            </a>
                        </td>
                        <td>
                            @if($project->url)
                                <a href="{{ $project->url }}" target="_blank" class="url-link">
                                    View Site <span class="external-icon">↗</span>
                                </a>
                            @else
                                <span class="no-url">No URL</span>
                            @endif
                        </td>
                        <td>{{ $project->created_at->format('M d, Y') }}</td>
                        <td>{{ $project->updated_at->format('M d, Y') }}</td>
                        <td class="actions-cell">
                            <div class="actions-menu">
                                <a href="{{ route('projects.edit', $project->id) }}" class="action-button edit-button">
                                    <span class="action-icon">✏️</span> Edit
                                </a>
                                <a href="{{ route('sections.index', ['project_id' => $project->id]) }}" class="action-button sections-button">
                                    <span class="action-icon">📑</span> Sections
                                </a>
                                <button wire:click="confirmDelete({{ $project->id }})" class="action-button delete-button">
                                    <span class="action-icon">🗑️</span> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-table">
                            <div class="empty-container">
                                <div class="empty-icon">📁</div>
                                <h3>No projects found</h3>
                                <p>Get started by creating your first project</p>
                                <a href="{{ route('projects.create') }}" class="empty-action">
                                    Create New Project
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container">
        {{ $projects->links() }}
    </div>
</div>
