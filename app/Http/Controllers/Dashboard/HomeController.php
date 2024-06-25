<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\ViewCount;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
   public function home()
   {
      $greeting  = $this->greetUser();
      $totalViews = ViewCount::count();
      $totalPosts = BlogPost::count();
         
      return view('dashboard.index', [
         'greeting' => $greeting,
         'totalViews' =>  $totalViews,
         'totalPosts' =>  $totalPosts
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
