<?php
namespace Editor\Library\Models;

use kahlan\plugin\Stub;
// use kahlan\plugin\Monkey;
use Editor\Library\Models\drawImage;

describe('drawImage', function () {
    beforeEach(function () {
        $this->drawImage = Stub::create([
            'extends' => drawImage::class
        ]);

        Stub::on($this->drawImage)
            ->method('getCurrentImage')
            ->andReturn([["O","X"],["O","X"],["O","X"]]);
    });

    describe('->drawNewImage()', function () {
        it('returns x by y image populated with O', function () {
            $expected = [
                ["O","O","O"],
                ["O","O","O"],
                ["O","O","O"],
                ["O","O","O"]
            ];

            expect($this->drawImage->drawNewImage(3, 4))->toEqual($expected);
        });
    });

    describe('->clearImage()', function () {
        it('returns x by y image populated with O where x and y are determined by current image height', function () {
            $expected = [
                ["O","O"],
                ["O","O"],
                ["O","O"]
            ];

            expect($this->drawImage->clearImage())->toEqual($expected);
        });
    });

    describe('->colorPixel()', function () {
        it('coloring a pixel within the image boundaries sets a new image', function () {
            expect($this->drawImage)->toReceive('getCurrentImage');
            expect($this->drawImage)->toReceive('setCurrentImage');
            $this->drawImage->colorPixel(1, 1, "R");
        });

        // it('coloring a pixel outsideof the image boundaries throws an exception', function () {
        //     expect($this->drawImage->colorPixel(1, 10, "R"))->toThrow(
        //         new \Exception("Pixel selected to be colored is outside of the image bounderies")
        //     );
        // });
    });
});
