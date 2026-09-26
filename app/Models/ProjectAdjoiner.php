<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectAdjoiner extends Model
{
    protected $fillable = [
        'project_parcel_id',
        'owner_name',
        'pin',
        'deed_book',
        'deed_page',
        'plat_book',
        'plat_page',
        'subdivision_name',
        'lot_number',
        'zoning',
    ];

    public function projectParcel(): BelongsTo
    {
        return $this->belongsTo(ProjectParcel::class);
    }
}
