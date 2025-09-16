<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TombolCetak extends Component
{
    public $label;
    public $href;

    /**
     * Create a new component instance.
     */
    public function __construct($label, $href)
    {
        $this->label = $label;
        $this->href = $href;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tombol-cetak');
    }
}
