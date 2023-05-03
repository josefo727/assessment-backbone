<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Municipality extends Model
{
    use HasFactory;
    /**
     * @return BelongsTo
     */
    public function federalEntity(): BelongsTo
    {
        return $this->belongsTo(FederalEntity::class);
    }
}
