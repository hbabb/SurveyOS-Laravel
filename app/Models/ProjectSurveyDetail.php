<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectSurveyDetail extends Model
{
    protected $fillable = [
        'project_id',
        'drawing_title',
        'ordered_by_name',
        'zoning_district',
        'setback_front_ft',
        'setback_side_ft',
        'setback_rear_ft',
        'setback_notes',
        'ngs_monument_name',
        'ngs_combined_scale_factor',
        'horizontal_datum',
        'vertical_datum',
        'basis_of_bearing',
        'benchmark_description',
        'certifying_surveyor_id',
        'field_date',
        'survey_date',
        'draft_date',
        'checked_date',
        'drafter_id',
        'checker_id',
        'revision',
        'sheet_no',
        'total_sheets',
        'scale_text',
        'field_draft_started',
        'recording_requested',
    ];

    protected $attributes = [
        'field_draft_started' => false,
    ];

    protected function casts(): array
    {
        return [
            'setback_front_ft' => 'decimal:2',
            'setback_side_ft' => 'decimal:2',
            'setback_rear_ft' => 'decimal:2',
            'ngs_combined_scale_factor' => 'decimal:8',
            'field_date' => 'date',
            'survey_date' => 'date',
            'draft_date' => 'date',
            'checked_date' => 'date',
            'field_draft_started' => 'boolean',
            'recording_requested' => 'boolean',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function certifyingSurveyor(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'certifying_surveyor_id');
    }

    public function drafter(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'drafter_id');
    }

    public function checker(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'checker_id');
    }
}
