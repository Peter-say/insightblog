<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavigationLink extends Model
{
    use HasFactory;

    protected $fillable = ['text', 'url', 'parent_id'];

    /**
     * Get the parent link.
     */
    public function parent()
    {
        return $this->belongsTo(NavigationLink::class, 'parent_id');
    }

    /**
     * Get the child links.
     */
    public function children()
    {
        return $this->hasMany(NavigationLink::class, 'parent_id');
    }
}
