<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * @property mixed $user_id
 */
class Contact extends Model
{
    protected $fillable = [
        'user_id',
        'company_id',
        'phone',
        'title',
        'contact_role',
        'account_status',
        'portal_enabled',
        'notification_email',
        'can_view_accounting',
        'can_view_all_company_projects',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'zip',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'portal_enabled' => 'boolean',
            'can_view_accounting' => 'boolean',
            'can_view_all_company_projects' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
