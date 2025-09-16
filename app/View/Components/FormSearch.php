<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormSearch extends Component
{
    public $placeholder;

    /**
     * Create a new component instance.
     */
    public function __construct($placeholder = 'Search...')
    {
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form-search');
    }
}
