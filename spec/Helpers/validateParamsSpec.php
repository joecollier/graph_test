<?php
namespace Editor\Helpers;

use kahlan\plugin\Stub;
use Editor\Helpers\validateParams;

describe('validateParams', function () {
    beforeEach(function () {
        $this->validateParams = Stub::create([
            'extends' => validateParams::class,
            'params' => []
        ]);
    });

    describe('->isValidDimensions()', function () {
        it('Returns true when x and y values are greater than 1 and lte 250', function () {
            expect($this->validateParams->isValidDimensions(100,100))->toBe(true);
        });

        it(
            'Returns false when x value is greater than 1 and lte 250 and y is greater than 250',
            function () {
                expect($this->validateParams->isValidDimensions(100,300))->toBe(false);
            }
        );

        it(
            'Returns false when x value is less than 1 and y value is greater than 1 and lte 250',
            function () {
                expect($this->validateParams->isValidDimensions(0,100))->toBe(false);
            }
        );
    });
});