<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiteIntake extends Model
{
    protected $fillable = [
        'contact_id',
        'address_line_1',
        'address_line_2',
        'city',
        'county',
        'state',
        'zip',
        'township',
        'pin',
        'notes',
    ];

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
}
