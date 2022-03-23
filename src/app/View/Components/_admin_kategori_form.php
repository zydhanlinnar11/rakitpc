<?php

namespace App\View\Components;

use Illuminate\View\Component;

class _admin_kategori_form extends Component
{
    public $kategori;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($kategori)
    {
        //
        $this->kategori = $kategori;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components._admin_kategori_form');
    }
}
