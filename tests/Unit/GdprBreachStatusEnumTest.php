<?php

use App\Enums\GdprBreachStatus;
use App\Enums\GdprDsrStatus;
use App\Enums\ComplaintStatus;
use App\Enums\RegulatoryFramework;

describe('GdprBreachStatus Enum', function () {

    it('has investigating, contained and closed cases', function () {
        $values = array_map(fn ($c) => $c->value, GdprBreachStatus::cases());
        expect($values)->toContain('investigating')
            ->toContain('contained')
            ->toContain('closed');
    });

    it('can be created from string', function () {
        expect(GdprBreachStatus::from('closed'))->toBe(GdprBreachStatus::CLOSED);
    });
});

describe('GdprDsrStatus Enum', function () {

    it('has all DSR status cases', function () {
        $values = array_map(fn ($c) => $c->value, GdprDsrStatus::cases());
        expect($values)->toContain('pending')
            ->toContain('extended')
            ->toContain('fulfilled')
            ->toContain('rejected');
    });
});

describe('ComplaintStatus Enum', function () {

    it('has all complaint status cases', function () {
        $values = array_map(fn ($c) => $c->value, ComplaintStatus::cases());
        expect($values)->toContain('open')
            ->toContain('investigating')
            ->toContain('resolved')
            ->toContain('rejected');
    });
});

describe('RegulatoryFramework Enum', function () {

    it('has all regulatory framework cases', function () {
        $values = array_map(fn ($c) => $c->value, RegulatoryFramework::cases());
        expect($values)->toContain('ivass')
            ->toContain('oam')
            ->toContain('gdpr')
            ->toContain('safety');
    });
});
