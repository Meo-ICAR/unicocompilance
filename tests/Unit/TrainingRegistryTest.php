<?php

use App\Models\TrainingRegistry;
use Illuminate\Support\Carbon;

describe('TrainingRegistry', function () {

    it('is valid when no expiry date is set', function () {
        $training = new TrainingRegistry(['valid_until' => null]);
        expect($training->isValid())->toBeTrue();
    });

    it('is valid when expiry date is in the future', function () {
        $training = new TrainingRegistry();
        $training->setRawAttributes(['valid_until' => Carbon::now()->addDays(30)->toDateString()]);
        expect($training->isValid())->toBeTrue();
    });

    it('is not valid when expiry date is in the past', function () {
        $training = new TrainingRegistry();
        $training->setRawAttributes(['valid_until' => Carbon::now()->subDay()->toDateString()]);
        expect($training->isValid())->toBeFalse();
    });

    it('returns null days until expiry when no expiry date', function () {
        $training = new TrainingRegistry(['valid_until' => null]);
        expect($training->getDaysUntilExpiry())->toBeNull();
    });

    it('returns positive days until expiry for future date', function () {
        $training = new TrainingRegistry();
        $training->setRawAttributes(['valid_until' => Carbon::now()->addDays(10)->toDateString()]);
        expect($training->getDaysUntilExpiry())->toBeGreaterThan(0);
    });

    it('returns negative days until expiry for past date', function () {
        $training = new TrainingRegistry();
        $training->setRawAttributes(['valid_until' => Carbon::now()->subDays(5)->toDateString()]);
        expect($training->getDaysUntilExpiry())->toBeLessThan(0);
    });

    it('has all required regulatory frameworks defined', function () {
        $frameworks = TrainingRegistry::REGULATORY_FRAMEWORKS;
        expect($frameworks)->toHaveKeys(['ivass', 'oam', 'gdpr', 'safety', 'aml', 'privacy', 'risk', 'compliance']);
    });
});
