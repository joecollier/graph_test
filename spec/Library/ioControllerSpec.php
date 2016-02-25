<?php
namespace Editor\Library;

use kahlan\plugin\Stub;
use kahlan\plugin\Monkey;
use Editor\Library\ioController;

describe('ioController', function () {
    beforeEach(function () {
        $this->ioController = Stub::create([
            'extends' => ioController::class
        ]);
    });

    describe('->parseUserInput()', function () {
        it('returns truthy value string is entered is string is not "x"', function () {
            expect($this->ioController->parseUserInput('a'))->toBeTruthy();
        });

        it('returns truthy value string is entered is string is "x"', function () {
            expect($this->ioController->parseUserInput('x'))->toBeFalsy();
        });
    });

    describe('->parseUserInput()', function () {
        beforeEach(function () {
            Monkey::patch('fgets', function(){return "x";});
        });

        it('returns truthy value string is entered is string is "x"', function () {
            expect($this->ioController)->toReceive('parseUserInput')->with("x");

            $this->ioController->promptUser();
        });
    });
});
