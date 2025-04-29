<?php

namespace App\Livewire\Sections;

use App\Models\Page;
use App\Models\Section;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $pageId;
    public $search = '';
    public $page;
    public $showDeleteModal = false;
    public $sectionToDelete = null;

    protected $queryString = ['search'];

    public function mount($page_id = null)
    {
        $this->pageId = $page_id;

        if ($page_id) {
            $this->page = Page::findOrFail($page_id);
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDelete($sectionId)
    {
        $this->sectionToDelete = $sectionId;
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->sectionToDelete = null;
        $this->showDeleteModal = false;
    }

    public function deleteSection()
    {
        if ($this->sectionToDelete) {
            Section::find($this->sectionToDelete)->delete();
            session()->flash('message', 'Section deleted successfully.');
            $this->sectionToDelete = null;
            $this->showDeleteModal = false;
        }
    }

    public function updateOrder($items)
    {
        foreach ($items as $item) {
            Section::find($item['value'])->update(['order' => $item['order']]);
        }
    }

    public function render()
    {
        $query = Section::query();

        if ($this->pageId) {
            $query->where('page_id', $this->pageId);
        } else {
            $query->with('page');
        }

        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', "%{$this->search}%")
                  ->orWhere('content', 'like', "%{$this->search}%");
            });
        }

        $sections = $query->orderBy('order', 'asc')
            ->paginate(10);

        return view('livewire.sections.index', [
            'sections' => $sections,
        ])->layout('components.layouts.app', [
            'title' => $this->pageId ? 'Sections for: ' . $this->page->title : 'All Sections'
        ]);
    }
}
