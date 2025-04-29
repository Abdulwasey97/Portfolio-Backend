<div class="form-container">
    <div class="form-header">
        <h1 class="form-title">{{ $pageId ? 'Edit Page' : 'Create New Page' }}</h1>
        <a href="{{ route('pages.index') }}" class="back-link">
            Back to Pages
        </a>
    </div>

    <form wire:submit.prevent="save">
        <div class="form-row">
            <label for="title" class="form-label">Title</label>
            <input type="text" id="title" wire:model="title" class="form-input">
            @error('title') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-row">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" id="slug" wire:model="slug" class="form-input">
            @error('slug') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-row">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" wire:model="description" rows="3" class="form-textarea"></textarea>
            @error('description') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <!-- Image Upload Field -->
        <div class="form-row">
            <label class="form-label">Featured Image</label>

            <div class="image-upload-container">
                <!-- Show existing image if available -->
                @if($existingImage)
                    <div class="existing-image">
                        <img src="{{ Storage::url($existingImage) }}" alt="Page Image">
                        <button type="button" wire:click="removeImage" class="remove-image-btn">
                            <span>×</span>
                        </button>
                    </div>
                @endif

                <!-- Image upload field -->
                <div class="image-upload-field {{ $existingImage ? 'has-image' : '' }}">
                    <label for="image" class="upload-label">
                        <div class="upload-icon">📷</div>
                        <div class="upload-text">
                            <span class="primary-text">Click to upload</span>
                            <span class="secondary-text">SVG, PNG, JPG or GIF (Max. 1MB)</span>
                        </div>
                        <input type="file" wire:model="image" id="image" class="file-input" accept="image/*">
                    </label>

                    <!-- Preview for newly selected image -->
                    @if($image)
                        <div class="image-preview" wire:loading.remove wire:target="image">
                            <img src="{{ $image->temporaryUrl() }}" alt="Image Preview">
                        </div>
                    @endif

                    <!-- Loading indicator while uploading -->
                    <div wire:loading wire:target="image" class="upload-loading">
                        <svg class="animate-spin h-6 w-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Uploading...</span>
                    </div>
                </div>
            </div>

            @error('image') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-row">
            <label for="status" class="form-label">Status</label>
            <select id="status" wire:model="status" class="form-select">
                <option value="draft">Draft</option>
                <option value="published">Published</option>
            </select>
            @error('status') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('pages.index') }}" class="btn btn-cancel">
                Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                {{ $pageId ? 'Update Page' : 'Create Page & Add Sections' }}
            </button>
        </div>
    </form>
</div>
