<?php

namespace App\Http\Livewire;

use App\Models\Coupon;
use Carbon\Carbon;
use Livewire\Component;
use Cart;
use Illuminate\Support\Facades\Auth;

class CartComponent extends Component
{
   public $couponcode;
   public $discount;
   public $subtotalAfterDiscount;
   public $taxAfterDiscount;
   public $totalAfterDiscount;

    public function increseQuantity($rowId){
        $product=Cart::instance('cart')->get($rowId);
        $qty=$product->qty + 1;
        Cart::instance('cart')->update($rowId,$qty);
        return redirect('/cart');
    }

    public function decreseQuantity($rowId){
        $product=Cart::instance('cart')->get($rowId);
        $qty=$product->qty - 1;
        Cart::instance('cart')->update($rowId,$qty);
        return redirect('/cart');
    }

    public function destroy($rowId){
        Cart::instance('cart')->remove($rowId);
        session()->flash('success_msg','Item has been removed'); 
        return redirect('/cart');
    }

    public function destroyAll(){
        Cart::instance('cart')->destroy();
        return redirect('/cart');
    }

    public function applyCouponCode(){
        $coupon =Coupon::where('code',$this->couponcode)->where('expiry_date','>=',Carbon::today())->where('cart_value','<=', Cart::instance('cart')->subtotal())->first();
        if(!$coupon){
            //session()->flash('msg','coupon Code is invalid');
            return redirect('/cart')->with('msg','coupon Code is invalid');
        }
        session()->put('coupon',[
            'code'=>$coupon->code,
            'type'=>$coupon->type,
            'value'=>$coupon->value,
            'cart_value'=>$coupon->cart_value
        ]);
        return redirect('/cart');
    }

    public function calculateDiscounts()
    {
        if(session()->has('coupon'))
        {
            if(session()->get('coupon')['type'] == 'fixed'){
                $this->discount=session()->get('coupon')['value'];
            }
            else{
                $this->discount=(Cart::instance('cart')->subtotal() * session()->get('coupon')['value'])/100;
            }
            $this->subtotalAfterDiscount= Cart::instance('cart')->subtotal()-$this->discount;
            $this->taxAfterDiscount=($this->subtotalAfterDiscount * config('cart.tax'))/100;
            $this->totalAfterDiscount=$this->subtotalAfterDiscount+$this->taxAfterDiscount;
        }
    }

    public function removeCoupon(){
        session()->forget('coupon');
        return redirect('/cart');
    }

    public function checkout(){
        if(Auth::check()){
            return redirect()->route('checkout');
        }
        else{
            return redirect()->route('login');
        }
    }

    public function setAmountForCheckout(){
        if(!Cart::instance('cart')->count()>0){
            session()->forget('checkout');
            return;
        }
        if(session()->has('coupon')){
            session()->put('checkout',[
                'discount' => $this->discount,
                'subtotal' => $this->subtotalAfterDiscount,
                'tax' => $this->taxAfterDiscount,
                'total' => $this->totalAfterDiscount
            ]);
        }
        else{
            session()->put('checkout',[
                'discount' => 0,
                'subtotal' => Cart::instance('cart')->subtotal(),
                'tax' => Cart::instance('cart')->tax(),
                'total' => Cart::instance('cart')->total()
            ]);
        }
    }

    public function render()
    {
        if(session()->has('coupon')){
            if(Cart::instance('cart')->subtotal() < session()->get('coupon')['cart_value']){
                session()->forget('coupon');
            }
            else{
                $this->calculateDiscounts();
            }
        }

        $this->setAmountForCheckout();
        return view('livewire.cart-component')->layout('layouts.base');
    }
}
