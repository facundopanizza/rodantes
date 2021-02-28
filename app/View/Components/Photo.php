<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Photo extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $link;
    public $key;

    public function __construct($link, $key)
    {
        $this->link = $link;
        $this->key = $key;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.photo');
    }
}
