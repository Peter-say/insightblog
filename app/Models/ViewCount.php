<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ViewCount extends Model
{
    use HasFactory;

    public function getTodaysViews()
    {
        $today = Carbon::today();
    
        $todaysViews = DB::table('view_counts')
            ->whereDate('created_at', $today)
            ->count();
    
        return $todaysViews;
    }
}
