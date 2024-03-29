<?php

namespace App\View\Components;

use Illuminate\View\Component;

class _content_container extends Component
{
    public $pageTitle;
    public $href;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($pageTitle, $href)
    {
        //
        $this->pageTitle = $pageTitle;
        $this->href = $href;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components._content_container');
    }
}
