<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Dashboard extends Component
{
    public function render()
    {
        // Auth::guard('web')->logout();

        // Session::invalidate();
        // Session::regenerateToken();

        return view('livewire.admin.dashboard');
    }
}
