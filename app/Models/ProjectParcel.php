<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectParcel extends Model
{
    protected $fillable = [
        'project_id',
        'sort_order',
        'parcel_label',
        'subject_pin',
        'current_owner_name',
        'subdivision_name',
        'lot_number',
        'site_area_acres',
        'deed_book',
        'deed_page',
        'plat_book',
        'plat_page',
    ];

    protected $attributes = [
        'sort_order' => 0,
    ];

    protected function casts(): array
    {
        return [
            'site_area_acres' => 'decimal:4',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function adjoiners(): HasMany
    {
        return $this->hasMany(ProjectAdjoiner::class);
    }

    public function parcelTransfers(): HasMany
    {
        return $this->hasMany(ParcelTransfer::class);
    }
}
