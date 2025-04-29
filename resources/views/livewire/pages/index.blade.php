<div class="table-container">
    <div class="table-header">
        <h1 class="table-title">Manage Pages</h1>
        <a href="{{ route('pages.create') }}" class="create-button">
            <span class="create-icon">+</span>
            Create New Page
        </a>
    </div>

    <div class="search-container">
        <div class="search-wrapper">

            <input type="text"
                   wire:model.live="search"
                   placeholder="Search pages by title or description..."
                   class="search-input">
            @if($search)
                <button wire:click="clearSearch" class="clear-button">×</button>
            @endif
        </div>
        <div style="margin-top: 5px; font-size: 0.8rem; color: #666;">
            Searching for: "{{ $search }}"
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">
            <span class="alert-icon">✓</span>
            <p>{{ session('message') }}</p>
        </div>
    @endif

    <!-- Delete confirmation modal using Livewire only -->
    @if($showDeleteModal)
        <div class="delete-modal-backdrop">
            <div class="delete-modal-content">
                <div class="modal-icon">🗑️</div>
                <h3 class="modal-title">Confirm Deletion</h3>
                <p class="modal-message">Are you sure you want to delete this page? This action cannot be undone.</p>
                <div class="modal-actions">
                    <button wire:click="cancelDelete" class="modal-btn cancel-btn">Cancel</button>
                    <button wire:click="deletePage" class="modal-btn delete-btn">Delete</button>
                </div>
            </div>
        </div>
    @endif

    <div class="data-table">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Sections</th>
                    <th>Created</th>
                    <th class="actions-column">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pages as $page)
                    <tr>
                        <td class="title-cell">
                            <a href="{{ route('pages.detail', $page->id) }}" class="page-title-link">
                                <div class="page-info">


                                    <span>{{ $page->title }}</span>
                                </div>
                            </a>
                        </td>
                        <td class="slug-cell">{{ $page->slug }}</td>
                        <td>
                            <span class="status-badge {{ $page->status === 'published' ? 'status-published' : 'status-draft' }}">
                                {{ $page->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('sections.index', ['page_id' => $page->id]) }}" class="sections-link">
                                <span class="sections-count">{{ $page->sections->count() }}</span> sections
                            </a>
                        </td>
                        <td>{{ $page->created_at->format('M d, Y') }}</td>
                        <td class="actions-cell">
                            <div class="actions-menu">
                                <a href="{{ route('pages.edit', $page->id) }}" class="action-button edit-button">
                                    <span class="action-icon">✏️</span> Edit
                                </a>
                                <a href="{{ route('sections.create', ['page_id' => $page->id]) }}" class="action-button add-button">
                                    <span class="action-icon">+</span> Add Section
                                </a>
                                <!-- Updated delete button -->
                                <button wire:click="confirmDelete({{ $page->id }})" class="action-button delete-button">
                                    <span class="action-icon">🗑️</span> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-table">
                            <div class="empty-container">
                                <div class="empty-icon">📄</div>
                                <h3>No pages found</h3>
                                <p>Get started by creating your first page</p>
                                <a href="{{ route('pages.create') }}" class="empty-action">Create New Page</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container">
        {{ $pages->links() }}
    </div>
</div>

<!-- Add Alpine.js if you haven't already added it in your layout -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
