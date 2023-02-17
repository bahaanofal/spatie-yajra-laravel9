<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AdminLayout extends Component
{
    public $title;
    public $routeHeadButton;
    public $headButton;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title = 'Title', $routeHeadButton = "route('/dashboard')", $headButton = "Dashboard")
    {
        $this->title = $title;
        $this->routeHeadButton = $routeHeadButton;
        $this->headButton = $headButton;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('layouts.admin-layout');
    }
}
