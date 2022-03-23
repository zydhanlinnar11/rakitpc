<?php

namespace App\View\Components;

use Illuminate\View\Component;

class _admin_brand_form extends Component
{
    public $brand;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($brand)
    {
        //
        $this->brand = $brand;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components._admin_brand_form');
    }
}
