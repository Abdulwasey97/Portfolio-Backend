<div class="table-container">
    <div class="table-header">
        <h1 class="table-title">
            {{ $pageId ? 'Sections for: ' . $page->title : 'All Sections' }}
        </h1>
        <div class="header-actions">
            @if($pageId)
                <a href="{{ route('sections.create', ['page_id' => $pageId]) }}" class="create-button">
                    <span class="create-icon">+</span>
                    Add Section
                </a>
                <a href="{{ route('pages.index') }}" class="secondary-button">
                    Back to Pages
                </a>
            @else
                <a href="{{ route('sections.create') }}" class="create-button">
                    <span class="create-icon">+</span>
                    Create New Section
                </a>
            @endif
        </div>
    </div>

    <div class="search-container">
        <div class="search-wrapper">
            <span class="search-icon">🔍</span>
            <input type="text" wire:model.live="search" placeholder="Search sections by title or content..."
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
                <p class="modal-message">Are you sure you want to delete this section? This action cannot be undone.</p>
                <div class="modal-actions">
                    <button wire:click="cancelDelete" class="modal-btn cancel-btn">Cancel</button>
                    <button wire:click="deleteSection" class="modal-btn delete-btn">Delete</button>
                </div>
            </div>
        </div>
    @endif

    <div class="data-table">
        <table>
            <thead>
                <tr>
                    <th>Order</th>
                    @if(!$pageId)
                        <th>Page</th>
                    @endif
                    <th>Title</th>
                    <th>Status</th>
                    <th>Updated</th>
                    <th class="actions-column">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sections as $section)
                    <tr>
                        <td class="order-cell">{{ $section->order }}</td>
                        @if(!$pageId)
                            <td>
                                <a href="{{ route('sections.index', ['page_id' => $section->page_id]) }}" class="page-link">
                                    {{ $section->page->title }}
                                </a>
                            </td>
                        @endif
                        <td class="title-cell">
                            <a href="{{ route('sections.detail', $section->id) }}" class="section-title-link">
                                <div class="section-info">
                                    @if($section->image)
                                        <div class="section-thumbnail">
                                            <img src="{{ Storage::url($section->image) }}" alt="{{ $section->title }}">
                                        </div>
                                    @endif
                                    <span>{{ $section->title }}</span>
                                </div>
                            </a>
                        </td>
                        <td>
                            <span class="status-badge {{ $section->status === 'published' ? 'status-published' : 'status-draft' }}">
                                {{ $section->status }}
                            </span>
                        </td>
                        <td>{{ $section->updated_at->format('M d, Y') }}</td>
                        <td class="actions-cell">
                            <div class="actions-menu">
                                <a href="{{ route('sections.edit', $section->id) }}" class="action-button edit-button">
                                    <span class="action-icon">✏️</span> Edit
                                </a>
                                <button wire:click="confirmDelete({{ $section->id }})" class="action-button delete-button">
                                    <span class="action-icon">🗑️</span> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $pageId ? 5 : 6 }}" class="empty-table">
                            <div class="empty-container">
                                <div class="empty-icon">📑</div>
                                <h3>No sections found</h3>
                                @if($pageId)
                                    <p>Get started by adding a section to this page</p>
                                    <a href="{{ route('sections.create', ['page_id' => $pageId]) }}" class="empty-action">
                                        Add Section
                                    </a>
                                @else
                                    <p>Get started by creating your first section</p>
                                    <a href="{{ route('sections.create') }}" class="empty-action">
                                        Create New Section
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container">
        {{ $sections->links() }}
    </div>
</div>
