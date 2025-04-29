<?php

namespace App\Livewire\Pages;

use App\Models\Page;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Form extends Component
{
    use WithFileUploads;

    public Page $page;
    public $pageId;
    public $title;
    public $slug;
    public $description;
    public $status = 'draft';
    public $image; // For new image upload
    public $existingImage; // To track existing image

    protected function rules()
    {
        return [
            'title' => 'required|min:3',
            'slug' => 'required|unique:pages,slug,' . $this->pageId,
            'description' => 'nullable',
            'image' => $this->pageId ? 'nullable|image|max:1024' : 'nullable|image|max:1024',
            'status' => 'required|in:draft,published',
        ];
    }

    public function mount($id = null)
    {
        $this->pageId = $id;

        if ($id) {
            $page = Page::findOrFail($id);
            $this->page = $page;
            $this->title = $page->title;
            $this->slug = $page->slug;
            $this->description = $page->description;
            $this->status = $page->status;
            $this->existingImage = $page->image;
        } else {
            $this->page = new Page();
        }
    }

    public function updatedTitle()
    {
        $this->slug = Str::slug($this->title);
    }

    public function removeImage()
    {
        if ($this->existingImage) {
            Storage::disk('public')->delete($this->existingImage);
            $this->existingImage = null;

            if ($this->pageId) {
                $this->page->update(['image' => null]);
            }
        }
    }

    public function save()
    {
        $this->validate();

        $this->page->title = $this->title;
        $this->page->slug = $this->slug;
        $this->page->description = $this->description;
        $this->page->status = $this->status;

        // Handle image upload
        if ($this->image) {
            // Delete old image if exists
            if ($this->existingImage) {
                Storage::disk('public')->delete($this->existingImage);
            }

            // Store the new image
            $imagePath = $this->image->store('page-images', 'public');
            $this->page->image = $imagePath;
        }

        $this->page->save();

        if ($this->pageId) {
            session()->flash('message', 'Page updated successfully.');
        } else {
            session()->flash('message', 'Page created successfully.');

            // Redirect to sections form
            return redirect()->route('sections.create', ['page_id' => $this->page->id]);
        }

        return redirect()->route('pages.index');
    }

    public function render()
    {
        return view('livewire.pages.form')->layout('components.layouts.app', [
            'title' => $this->pageId ? 'Edit Page' : 'Create New Page'
        ]);
    }
}
