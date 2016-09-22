<?php
namespace Editor\Controllers;

use kahlan\plugin\Stub;
use kahlan\plugin\Monkey;
use Editor\Controllers\IoController;

describe(IoController::class, function () {
    beforeEach(function () {
        $this->io_controller = new IoController();
        Stub::on($this->io_controller)->method('handleInput')->andReturn(true);

        $reflectionClass = new \ReflectionClass($this->io_controller);
        $this->parseUserInput = $reflectionClass->getMethod('parseUserInput');
        $this->parseUserInput->setAccessible(true);
    });

    describe('->parseUserInput()', function () {
        it('returns truthy value string is entered is string is not "x"', function () {
            expect($this->parseUserInput->invokeArgs($this->io_controller, ['A']))->toBeTruthy();
        });

        it('returns falsy value string is entered is string is "x"', function () {
            expect($this->parseUserInput->invokeArgs($this->io_controller, ['X']))->toBeFalsy();
        });
    });
});
