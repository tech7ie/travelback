<?php

namespace App\View\Components;

use App\Http\Controllers\ContentController;
use App\Models\Content;
use Illuminate\View\Component;

class Footer extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $contentController = new ContentController();
        $footerContacts = $contentController->getContacts();
        return view('components.footer', ['footerContacts' => $footerContacts]);
    }
}
