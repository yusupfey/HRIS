<?php

namespace App\View\Components;

use App\Models\Employee;
use Illuminate\View\Component;
use Illuminate\View\View;

class MainLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {

        return view('layouts.main');
    }
}
