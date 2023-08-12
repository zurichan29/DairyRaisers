<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class CartItem extends Component
{
    /**
     * Create a new component instance.
     */
    public $name;
    public $variant;
    public $price;
    public $quantity;
    public $total;

    public function __construct($name, $variant, $price, $quantity, $total)
    {
        $this->name = $name;
        $this->variant = $variant;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->total = $total;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.cart-item');
    }
}
