<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unitofmeasure extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit',
    ];
}
