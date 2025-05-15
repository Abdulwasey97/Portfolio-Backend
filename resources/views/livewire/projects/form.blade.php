<div>
    <div class="form-container">
        <div class="form-header">
            <h1 class="form-title">{{ $projectId ? 'Edit Project' : 'Create New Project' }}</h1>
            <a href="{{ route('projects.index') }}" class="back-link">
                Back to Projects
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
                <div class="slug-input-group">
                    <input type="text" id="slug" wire:model="slug" class="form-input">
                    <button type="button" wire:click="generateSlug" class="slug-generate-btn" title="Generate from title">
                        ↻
                    </button>
                </div>
                <div class="field-hint">Used for URL: example.com/projects/your-slug</div>
                @error('slug') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-row">
                <label for="url" class="form-label">Project URL</label>
                <input type="url" id="url" wire:model="url" class="form-input" placeholder="https://example.com">
                @error('url') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <!-- Image Upload Field -->
            <div class="form-row">
                <label class="form-label">Project Image</label>

                <div class="image-upload-container">
                    <!-- Show existing image if available -->
                    @if($existingImage)
                        <div class="existing-image">
                            <img src="{{ Storage::url($existingImage) }}" alt="Project Image">
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
                <label for="description" class="form-label">Description</label>
                <textarea id="description" wire:model="description" rows="5" class="form-textarea"></textarea>
                @error('description') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('projects.index') }}" class="btn btn-cancel">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    {{ $projectId ? 'Update Project' : 'Create Project' }}
                </button>
            </div>
        </form>
    </div>

    <!-- CKEditor Script -->
    <script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            ClassicEditor
                .create(document.querySelector('#description'), {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'outdent', 'indent', '|', 'imageUpload', 'blockQuote', 'insertTable', 'mediaEmbed', 'undo', 'redo']
                })
                .then(editor => {
                    // Set initial data if needed
                    if (editor.getData() === '') {
                        editor.setData(`{!! $description !!}`);
                    }

                    // Update Livewire property when CKEditor changes
                    editor.model.document.on('change:data', () => {
                        @this.set('description', editor.getData());
                    });

                    // Listen for new values from Livewire
                    window.addEventListener('updated-description', event => {
                        if (editor.getData() !== event.detail.description) {
                            editor.setData(event.detail.description);
                        }
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
</div>
