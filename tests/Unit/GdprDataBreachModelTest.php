<?php

use App\Models\COMPILANCE\GdprDataBreach;

describe('GdprDataBreach Model', function () {
    it('uses soft deletes', function () {
        expect(in_array(
            \Illuminate\Database\Eloquent\SoftDeletes::class,
            class_uses_recursive(GdprDataBreach::class)
        ))->toBeTrue();
    });

    it('has all nature of breach types defined', function () {
        $types = GdprDataBreach::NATURE_OF_BREACH_TYPES;
        expect($types)->toHaveKeys([
            'unauthorized_access',
            'data_loss',
            'ransomware',
            'phishing',
            'malware',
            'physical_theft',
            'human_error',
            'other',
        ]);
    });

    it('has all status types defined', function () {
        $statuses = GdprDataBreach::STATUS_TYPES;
        expect($statuses)->toHaveKeys(['investigating', 'contained', 'closed']);
    });

    it('casts is_notified_to_authority as boolean', function () {
        $breach = new GdprDataBreach(['is_notified_to_authority' => 1]);
        expect($breach->is_notified_to_authority)->toBeBool();
    });

    it('casts subjects_affected_count as integer', function () {
        $breach = new GdprDataBreach(['subjects_affected_count' => '42']);
        expect($breach->subjects_affected_count)->toBeInt();
    });

    it('has all required fillable fields', function () {
        $fillable = (new GdprDataBreach())->getFillable();
        expect($fillable)
            ->toContain('company_id')
            ->toContain('incident_date')
            ->toContain('discovery_date')
            ->toContain('nature_of_breach')
            ->toContain('subjects_affected_count')
            ->toContain('is_notified_to_authority')
            ->toContain('status');
    });
});
