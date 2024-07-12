<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class ContentLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public $content;

    public function __construct($content)
    {
        $this->content = $content;
    }
    public function render(): View
    {
        return view('layouts.content');
    }
}
