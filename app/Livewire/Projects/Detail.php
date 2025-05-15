<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;

class Detail extends Component
{
    public $project;

    public function mount($id)
    {
        $this->project = Project::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.projects.detail', [
            'project' => $this->project
        ])->layout('components.layouts.app', ['title' => $this->project->title]);
    }
}
