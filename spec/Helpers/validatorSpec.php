<?php
namespace Editor\Helpers;

use kahlan\plugin\Stub;
use Editor\Helpers\validator;

describe('validator', function () {
    beforeEach(function () {
        $this->ValidateParams = Stub::create([
            'extends' => validator::class,
            'params' => []
        ]);
    });

    describe('->isValidDimensions()', function () {
        it('Returns true when x and y values are greater than 1 and lte 250', function () {
            expect($this->ValidateParams->isValidDimensions(100,100))->toBe(true);
        });

        it(
            'Returns false when x value is greater than 1 and lte 250 and y is greater than 250',
            function () {
                expect($this->ValidateParams->isValidDimensions(100,300))->toBe(false);
            }
        );

        it(
            'Returns false when x value is less than 1 and y value is greater than 1 and lte 250',
            function () {
                expect($this->ValidateParams->isValidDimensions(0,100))->toBe(false);
            }
        );
    });
});