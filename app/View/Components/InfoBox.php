<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InfoBox extends Component
{
    public $title = "";
    public $color = "";
    public $icons = "";
    public $id = "";

    /**
     * Create a new component instance.
     */
    public function __construct($infoTitle, $infoColor, $infoId, $infoIcon)
    {
        $this->title = $infoTitle;
        $this->color = $infoColor;
        $this->id  = $infoId;
        $this->icons = $infoIcon;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.info-box');
    }
}
