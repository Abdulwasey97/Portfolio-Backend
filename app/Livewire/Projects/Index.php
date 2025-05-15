<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $showDeleteModal = false;
    public $projectToDelete = null;

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDelete($projectId)
    {
        $this->projectToDelete = $projectId;
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->projectToDelete = null;
        $this->showDeleteModal = false;
    }

    public function deleteProject()
    {
        if ($this->projectToDelete) {
            Project::find($this->projectToDelete)->delete();
            session()->flash('message', 'Project deleted successfully!');
            $this->projectToDelete = null;
            $this->showDeleteModal = false;
        }
    }

    public function render()
    {
        $projects = Project::query()
            ->when($this->search, function($query) {
                return $query->where('title', 'like', "%{$this->search}%")
                    ->orWhere('description', 'like', "%{$this->search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.projects.index', [
            'projects' => $projects
        ])->layout('components.layouts.app', ['title' => 'Projects']);
    }
}
