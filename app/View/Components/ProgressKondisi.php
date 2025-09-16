<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProgressKondisi extends Component
{
    public $judul;
    public $jumlah;
    public $kondisi;
    public $color;

    /**
     * Create a new component instance.
     */
    public function __construct($judul, $jumlah, $kondisi, $color)
    {
        $this->judul = $judul;
        $this->jumlah = $jumlah;
        $this->kondisi = $kondisi;
        $this->color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.progress-kondisi');
    }
}
