<?php

namespace App\Livewire\Sections;

use App\Models\Section;
use Livewire\Component;

class Detail extends Component
{
    public $section;
    public $sectionId;

    public function mount($id)
    {
        $this->sectionId = $id;
        $this->section = Section::with('page')->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.sections.detail');
    }
}
