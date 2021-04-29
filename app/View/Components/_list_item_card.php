<?php

namespace App\View\Components;

use Illuminate\View\Component;

class _list_item_card extends Component
{
    public $key;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($key)
    {
        //
        $this->key = $key;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components._list_item_card');
    }
}
