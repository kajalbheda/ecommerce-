<?php

namespace App\Http\Livewire\User;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserOrdersComponent extends Component
{
    public function render()
    {
        $order=Order::where('user_id',Auth::user()->id)->get();
        return view('livewire.user.user-orders-component',['orders'=>$order])->layout('layouts.base');
    }
}
