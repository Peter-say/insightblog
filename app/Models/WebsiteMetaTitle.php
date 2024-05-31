<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteMetaTitle extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function appName()
    {
        return $this->meta_title;
    }

}
