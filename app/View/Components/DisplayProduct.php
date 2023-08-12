<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class DisplayProduct extends Component
{
    /**
     * Create a new component instance.
     */

    public $name;
    public $variant;
    public $price;
    public $quantity;
    public $total;
    public $img;

    public function __construct($name, $variant, $price, $quantity, $total, $img)
    {
        $this->name = $name;
        $this->variant = $variant;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->total = $total;
        $this->img = $img;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.display-product');
    }
}
