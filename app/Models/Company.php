<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'name',
        'account_status',
        'main_email',
        'main_phone',
        'accounting_email',
        'billing_address_line_1',
        'billing_address_line_2',
        'billing_city',
        'billing_state',
        'billing_zip',
        'physical_address_line_1',
        'physical_address_line_2',
        'physical_city',
        'physical_state',
        'physical_zip',
        'billing_notes',
        'notes',
        'restrict_contacts_to_assigned_projects',
    ];

    protected function casts(): array
    {
        return [
            'restrict_contacts_to_assigned_projects' => 'boolean',
        ];
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }
}
