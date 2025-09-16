<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormSelect extends Component
{
    public $name;
    public $label;
    public $value;
    public $options;
    public $optionData;
    public $optionValue;
    public $optionLabel;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $name,
        $label = null,
        $value = null,
        $options = [],
        $optionData = null,
        $optionValue = null,
        $optionLabel = null,
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->options = $options;
        $this->optionData = $optionData;
        $this->optionValue = $optionValue;
        $this->optionLabel = $optionLabel;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form-select');
    }
}
