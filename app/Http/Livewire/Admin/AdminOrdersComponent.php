<?php

namespace App\Http\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;

class AdminOrdersComponent extends Component
{
    public function render()
    {
        $orders=Order::orderBy('created_at','DESC')->paginate(20);
        return view('livewire.admin.admin-orders-component',['orders'=>$orders])->layout('layouts.base');
    }
}
