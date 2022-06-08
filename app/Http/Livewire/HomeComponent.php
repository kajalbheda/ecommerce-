<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;

class HomeComponent extends Component
{
    public function render()
    {
        $lproducts=Product::orderBy('created_at','DESC')->get()->take(8)
;        return view('livewire.home-component',['lproducts'=>$lproducts])->layout('layouts.base');
    }
}
