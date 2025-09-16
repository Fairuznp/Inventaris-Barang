<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TombolAksi extends Component
{
    public $href;
    public $type;

    /**
     * Create a new component instance.
     */
    public function __construct($href, $type)
    {
        $this->href = $href;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tombol-aksi');
    }
}
