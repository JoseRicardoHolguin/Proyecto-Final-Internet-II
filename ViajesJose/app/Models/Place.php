<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Place extends Model
{
    protected $table = 'places';
    protected $fillable = ['travel_id', 'name', 'description', 'latitude', 'longitude'];

    public function travel(): BelongsTo
    {
        return $this->belongsTo(Travel::class);
    }
}
