<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ZipCode extends Model
{
    use HasFactory;

    /**
     * @return BelongsTo
     */
    public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class);
    }

    /**
     * @return BelongsTo
     */
    public function federalEntity(): BelongsTo
    {
        return $this->belongsTo(FederalEntity::class);
    }

    /**
     * @return HasMany
     */
    public function settlements(): HasMany
    {
        return $this->hasMany(Settlement::class);
    }
}
