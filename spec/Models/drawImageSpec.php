<?php
namespace Editor\Models;

use kahlan\plugin\Stub;
use Editor\Models\drawImage;

describe('drawImage', function () {
    beforeEach(function () {
        $this->drawImage = Stub::create([
            'extends' => drawImage::class,
            'params' => []
        ]);
    });

    describe('->drawNewImage()', function () {
        it('returns x by y image populated with O', function () {
            $expected = [
                ["O","O","O"],
                ["O","O","O"],
                ["O","O","O"],
                ["O","O","O"]
            ];

            expect($this->drawImage->drawNewImage(3, 4)->pixels)->toEqual($expected);
        });
    });
});
