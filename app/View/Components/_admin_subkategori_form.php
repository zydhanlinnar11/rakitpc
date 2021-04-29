<?php

namespace App\View\Components;

use Illuminate\View\Component;

class _admin_subkategori_form extends Component
{
    public $subkategori;
    public $listKategori;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($subkategori, $listKategori)
    {
        //
        $this->subkategori = $subkategori;
        $this->listKategori = $listKategori;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components._admin_subkategori_form');
    }
}
