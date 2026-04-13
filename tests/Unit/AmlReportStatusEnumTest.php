<?php

use App\Enums\AmlReportStatus;

describe('AmlReportStatus Enum', function () {

    it('has all expected cases', function () {
        $cases = AmlReportStatus::cases();
        $values = array_map(fn ($c) => $c->value, $cases);

        expect($values)->toContain('drafted')
            ->toContain('evaluating')
            ->toContain('reported')
            ->toContain('archived');
    });

    it('returns correct italian labels', function () {
        expect(AmlReportStatus::DRAFTED->label())->toBe('Bozza');
        expect(AmlReportStatus::EVALUATING->label())->toBe('In Valutazione');
        expect(AmlReportStatus::REPORTED->label())->toBe('Segnalata UIF');
        expect(AmlReportStatus::ARCHIVED->label())->toBe('Archiviata');
    });

    it('can be created from string value', function () {
        expect(AmlReportStatus::from('drafted'))->toBe(AmlReportStatus::DRAFTED);
        expect(AmlReportStatus::from('reported'))->toBe(AmlReportStatus::REPORTED);
    });

    it('returns null for invalid value with tryFrom', function () {
        expect(AmlReportStatus::tryFrom('invalid_status'))->toBeNull();
    });
});
