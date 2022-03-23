<?php

namespace App\View\Components;

use Illuminate\View\Component;

class _admin_produk_form extends Component
{
    public $listKategori;
    public $listSubkategori;
    public $listBrand;
    public $processorCategoryId;
    public $motherboardCategoryId;
    public $listSocket;
    public $produk;
    public $isThisProcessorOrMotherboard;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($listKategori, $listSubkategori, $listBrand, $processorCategoryId, $motherboardCategoryId, $listSocket, $produk, $isThisProcessorOrMotherboard)
    {
        //
        $this->listKategori = $listKategori;
        $this->listBrand = $listBrand;
        $this->processorCategoryId = $processorCategoryId;
        $this->listSocket = $listSocket;
        $this->produk = $produk;
        $this->listSubkategori = $listSubkategori;
        $this->motherboardCategoryId = $motherboardCategoryId;
        $this->isThisProcessorOrMotherboard = $isThisProcessorOrMotherboard;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components._admin_produk_form');
    }
}
