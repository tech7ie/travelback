<?php

namespace App\View\Components;

use App\Http\Controllers\RoutesController;
use Illuminate\View\Component;

class Search extends Component
{


    public $currentRoute;

    public $currentRoutePlaces;

    public $debug;


    /**
     * Create the component instance.
     *
     * @param object $currentRoute
     *
     * @param object $currentRoutePlaces
     *
     */
    public function __construct($debug, object $currentRoute, array $currentRoutePlaces)
    {
        $this->debug = $debug;
        $this->currentRoute = $currentRoute;
        $this->currentRoutePlaces = $currentRoutePlaces;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {

        $routeList = new RoutesController();

        $routeList = $routeList->routeList();
        return view('components.search', ['routeList' => $routeList]);
    }
}
