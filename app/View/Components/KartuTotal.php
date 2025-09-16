<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class KartuTotal extends Component
{
    public $text;
    public $total;
    public $route;
    public $icon;
    public $color;

    /**
     * Create a new component instance.
     */
    public function __construct($text, $total, $route, $icon, $color)
    {
        $this->text = $text;
        $this->total = $total;
        $this->route = $route;
        $this->icon = $icon;
        $this->color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.kartu-total');
    }
}
