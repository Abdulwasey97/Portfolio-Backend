<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CkEditor extends Component
{
    public $id;
    public $value;
    public $label;
    public $placeholder;
    public $rows;

    public function __construct($id, $value = '', $label = null, $placeholder = '', $rows = 5)
    {
        $this->id = $id;
        $this->value = $value;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->rows = $rows;
    }

    public function render()
    {
        return view('components.ck-editor');
    }
}
