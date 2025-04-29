<?php

namespace App\Livewire\Pages;

use App\Models\Page;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $showDeleteModal = false;
    public $pageToDelete = null;

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDelete($pageId)
    {
        $this->pageToDelete = $pageId;
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->pageToDelete = null;
        $this->showDeleteModal = false;
    }

    public function deletePage()
    {
        if ($this->pageToDelete) {
            Page::find($this->pageToDelete)->delete();
            session()->flash('message', 'Page deleted successfully.');
            $this->pageToDelete = null;
            $this->showDeleteModal = false;
        }
    }

    public function render()
    {
        \Log::info('Search term: ' . $this->search);

        $pages = Page::query()
            ->when($this->search, function ($query) {
                return $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhere('slug', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.pages.index', [
            'pages' => $pages,
        ])->layout('components.layouts.app', [
            'title' => 'Manage Pages'
        ]);
    }

    public function clearSearch()
    {
        $this->search = '';
    }
}
