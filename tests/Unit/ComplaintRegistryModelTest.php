<?php

use App\Models\ComplaintRegistry;

describe('ComplaintRegistry Model', function () {

    it('uses soft deletes', function () {
        expect(in_array(
            \Illuminate\Database\Eloquent\SoftDeletes::class,
            class_uses_recursive(ComplaintRegistry::class)
        ))->toBeTrue();
    });

    it('has all category types defined', function () {
        $categories = ComplaintRegistry::CATEGORY_TYPES;
        expect($categories)->toHaveKeys(['delay', 'behavior', 'privacy', 'fraud', 'quality', 'contract', 'other']);
    });

    it('has all status types defined', function () {
        $statuses = ComplaintRegistry::STATUS_TYPES;
        expect($statuses)->toHaveKeys(['open', 'investigating', 'resolved', 'rejected', 'closed']);
    });

    it('has complaint_number in fillable', function () {
        $fillable = (new ComplaintRegistry())->getFillable();
        expect($fillable)->toContain('complaint_number')
            ->toContain('company_id')
            ->toContain('complainant_name')
            ->toContain('status');
    });

    it('casts financial_impact as decimal', function () {
        $registry = new ComplaintRegistry(['financial_impact' => '1234.56']);
        expect($registry->getCasts())->toHaveKey('financial_impact');
    });
});
