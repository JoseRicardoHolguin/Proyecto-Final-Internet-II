<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Travel extends Model
{
    protected $table = 'travels';
    protected $fillable = ['user_id', 'name', 'start_date', 'end_date'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function places(): HasMany
    {
        return $this->hasMany(Place::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
