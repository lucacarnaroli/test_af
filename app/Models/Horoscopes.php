<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horoscopes extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'date',
        'zodiac_sign',
    ];

    protected $dateFormat = 'Y-m-d';
}
