<?php

namespace App\Livewire;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CartCounter extends Component
{
    protected $listeners = ['cart-updated' => '$refresh'];

    public function render()
    {
        $count = Auth::check()
            ? Cart::where('user_id', Auth::id())->sum('jumlah')
            : 0;

        return view('livewire.cart-counter', compact('count'));
    }
}
