<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParcelTransfer extends Model
{
    protected $fillable = [
        'project_parcel_id',
        'grantor',
        'grantee',
        'deed_book',
        'deed_page',
        'plat_book',
        'plat_page',
        'recorded_date',
        'instrument_type',
        'project_document_id',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'recorded_date' => 'date',
        ];
    }

    public function projectParcel(): BelongsTo
    {
        return $this->belongsTo(ProjectParcel::class);
    }

    public function projectDocument(): BelongsTo
    {
        return $this->belongsTo(ProjectDocument::class);
    }
}
