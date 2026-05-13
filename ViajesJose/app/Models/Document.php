<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    protected $table = 'documents';
    protected $fillable = ['travel_id', 'name', 'file_path', 'required'];

    public function travel(): BelongsTo
    {
        return $this->belongsTo(Travel::class);
    }
}
