<?php
namespace Editor\Controllers;

use kahlan\plugin\Stub;
use kahlan\plugin\Monkey;
use Editor\Controllers\IoController;

xdescribe('IoController', function () {
    beforeEach(function () {
        $this->IoController = Stub::create([
            'extends' => IoController::class
        ]);
    });

    describe('->parseUserInput()', function () {
        it('returns truthy value string is entered is string is not "x"', function () {
            expect($this->IoController->parseUserInput('A'))->toBeTruthy();
        });

        it('returns falsy value string is entered is string is "x"', function () {
            expect($this->IoController->parseUserInput('X'))->toBeFalsy();
        });
    });
});
