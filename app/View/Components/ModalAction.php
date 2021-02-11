<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ModalAction extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $message;
    public $key;

    public function __construct($message, $key)
    {
        $this->message = $message;
        $this->key = $key;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.modal-action');
    }
}
