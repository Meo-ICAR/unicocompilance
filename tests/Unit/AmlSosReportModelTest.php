<?php

use App\Models\AmlSosReport;
use App\Enums\AmlReportStatus;

describe('AmlSosReport Model', function () {

    it('uses soft deletes', function () {
        expect(in_array(
            \Illuminate\Database\Eloquent\SoftDeletes::class,
            class_uses_recursive(AmlSosReport::class)
        ))->toBeTrue();
    });

    it('uses the compliance database connection', function () {
        $model = new AmlSosReport();
        expect($model->getConnectionName())->toBe('mysql_compliance');
    });

    it('casts suspicion_indicators as array', function () {
        $casts = (new AmlSosReport())->getCasts();
        expect($casts)->toHaveKey('suspicion_indicators');
        expect($casts['suspicion_indicators'])->toBe('array');
    });

    it('casts forwarded_to_fiu as boolean', function () {
        $casts = (new AmlSosReport())->getCasts();
        expect($casts)->toHaveKey('forwarded_to_fiu');
        expect($casts['forwarded_to_fiu'])->toBe('boolean');
    });

    it('casts status as AmlReportStatus enum', function () {
        $casts = (new AmlSosReport())->getCasts();
        expect($casts)->toHaveKey('status');
        expect($casts['status'])->toBe(AmlReportStatus::class);
    });

    it('has all required fillable fields', function () {
        $fillable = (new AmlSosReport())->getFillable();
        expect($fillable)->toContain('company_id')
            ->toContain('agent_id')
            ->toContain('suspicion_indicators')
            ->toContain('forwarded_to_fiu')
            ->toContain('status');
    });

    it('has agent relationship defined', function () {
        $model = new AmlSosReport();
        expect(method_exists($model, 'agent'))->toBeTrue();
    });
});
