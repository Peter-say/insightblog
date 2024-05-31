<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website_meta_description extends Model
{
    use HasFactory;
    protected $fillable = ['description'];

    public function Description()
    {
        return $this->description;
    }
}
