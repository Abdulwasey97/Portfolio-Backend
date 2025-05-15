<?php

namespace App\Livewire\Sections;

use App\Models\Page;
use App\Models\Section;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Form extends Component
{
    use WithFileUploads;

    public Section $section;
    public $sectionId;
    public $pageId;
    public $pages = [];
    public $title;
    public $content;
    public $image; // For new image upload
    public $existingImage; // To track existing image
    public $order = 0;
    public $status = 'draft';

    protected function rules()
    {
        return [
            'title' => 'required|min:3',
            'content' => 'required',
            'image' => $this->sectionId ? 'nullable|image|max:1024' : 'nullable|image|max:1024',
            'order' => 'nullable|integer',
            'status' => 'required|in:draft,published',
        ];
    }

    public function mount($id = null, $page_id = null)
    {
        $this->pages = Page::orderBy('title')->get();
        $this->sectionId = $id;
        $this->pageId = $page_id;

        if ($id) {
            $section = Section::findOrFail($id);
            $this->section = $section;
            $this->pageId = $section->page_id;
            $this->title = $section->title;
            $this->content = $section->content;
            $this->order = $section->order;
            $this->status = $section->status;
            $this->existingImage = $section->image;
        } else {
            $this->section = new Section();

            // Get next order number if page is selected
            if ($this->pageId) {
                $maxOrder = Section::where('page_id', $this->pageId)->max('order');
                $this->order = $maxOrder ? $maxOrder + 1 : 1;
            }
        }
    }

    public function updatedPageId()
    {
        if ($this->pageId) {
            $maxOrder = Section::where('page_id', $this->pageId)->max('order');
            $this->order = $maxOrder ? $maxOrder + 1 : 1;
        }
    }

    public function removeImage()
    {
        if ($this->existingImage) {
            Storage::disk('public')->delete($this->existingImage);
            $this->existingImage = null;

            if ($this->sectionId) {
                $this->section->update(['image' => null]);
            }
        }
    }

    public function save()
    {
        $this->validate();

        $this->section->page_id = $this->pageId;
        $this->section->title = $this->title;
        $this->section->content = $this->content;
        $this->section->order = $this->order;
        $this->section->status = $this->status;

        // Handle image upload
        if ($this->image) {
            // Delete old image if exists
            if ($this->existingImage) {
                Storage::disk('public')->delete($this->existingImage);
            }

            // Store the new image
            $imagePath = $this->image->store('section-images', 'public');
            $this->section->image = $imagePath;
        }

        $this->section->save();

        if ($this->sectionId) {
            session()->flash('message', 'Section updated successfully.');
        } else {
            session()->flash('message', 'Section created successfully.');
        }

        if ($this->pageId) {
            return redirect()->route('sections.index', ['page_id' => $this->pageId]);
        }

        return redirect()->route('sections.index');
    }

    public function render()
    {
        return view('livewire.sections.form')->layout('components.layouts.app', [
            'title' => $this->sectionId ? 'Edit Section' : 'Create New Section'
        ]);
    }
}
