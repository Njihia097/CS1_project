<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AdminLayout extends Component
{
    public $artistCount;
    public $contentCount;

    public function __construct($artistCount, $contentCount)
    {
        $this->artistCount = $artistCount;
        $this->contentCount = $contentCount;
    }
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.admin');
    }
}
