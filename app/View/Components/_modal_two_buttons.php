<?php

namespace App\View\Components;

use Illuminate\View\Component;

class _modal_two_buttons extends Component
{
    public $id;
    public $title;
    public $prompt;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $title, $prompt)
    {
        //
        $this->id = $id;
        $this->title = $title;
        $this->prompt = $prompt;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components._modal_two_buttons');
    }
}
