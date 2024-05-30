<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $greeting  = $this->greetUser();
        return view('dashboard.index', [
            'greeting' => $greeting,
        ]);
    }

    public function greetUser()
    {
       $currentHour = Carbon::now()->hour;
       if ($currentHour >= 5 && $currentHour < 12) {
          $greeting = 'Good morning';
       } elseif ($currentHour >= 12 && $currentHour < 18) {
          $greeting = 'Good afternoon';
       } else {
          $greeting = 'Good evening';
       }
       return $greeting;
    }
}
