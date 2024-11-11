<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Image extends Component
{
    public $model, $collection, $conversion, $class;
    /**
     * Create a new component instance.
     */
    public function __construct($model, $collection, $conversion, $class="")
    {
        $this->model = $model;
        $this->collection = $collection;
        $this->conversion = $conversion;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        // dd($this->model->category_name);
        return view('components.image');
    }
}
