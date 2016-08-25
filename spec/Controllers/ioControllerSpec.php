<?php
namespace Editor\Controllers;

use kahlan\plugin\Stub;
use kahlan\plugin\Monkey;
use Editor\Controllers\ioController;

xdescribe('ioController', function () {
    beforeEach(function () {
        $this->ioController = Stub::create([
            'extends' => ioController::class
        ]);
    });

    describe('->parseUserInput()', function () {
        it('returns truthy value string is entered is string is not "x"', function () {
            expect($this->ioController->parseUserInput('A'))->toBeTruthy();
        });

        it('returns falsy value string is entered is string is "x"', function () {
            expect($this->ioController->parseUserInput('X'))->toBeFalsy();
        });
    });
});
