<?php

namespace App\Models;

use App\Enums\TrafficLightEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrafficLightLog extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['status', 'message'];

    /**
     * @var string[]
     */
    protected $casts = ['status' => TrafficLightEnums::class];
}
