<?php

namespace App\Livewire\Pages;

use App\Models\Page;
use Livewire\Component;

class Detail extends Component
{
    public $page;
    public $pageId;

    public function mount($id)
    {
        $this->pageId = $id;
        $this->page = Page::with('sections')->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.pages.detail');
    }
}
