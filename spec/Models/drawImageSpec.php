<?php
namespace Editor\Models;

use kahlan\plugin\Stub;
use Editor\Models\drawImage;

describe('drawImage', function () {
    beforeEach(function () {
        $this->drawImage = Stub::create([
            'extends' => drawImage::class
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

            Stub::on($this->drawImage)
                ->method('getCurrentImage')
                ->andReturn([["O","X"],["O","X"],["O","X"]]);

            expect($this->drawImage->clearImage())->toEqual($expected);
        });
    });

    describe('->colorPixel()', function () {
        it('coloring a pixel within the image boundaries sets a new image', function () {
            Stub::on($this->drawImage)
                ->method('getCurrentImage')
                ->andReturn([["O","X"],["O","X"],["O","X"]]);

            expect($this->drawImage)->toReceive('getCurrentImage');
            expect($this->drawImage)->toReceive('setCurrentImage');
            $this->drawImage->colorPixel(1, 1, "R");
        });
    });

    describe('->drawVertical()', function () {
        it('draws vertical line with color R from y=1 to y=2 in column 2', function () {
            $expected = [
                ["O","R"],
                ["O","R"],
                ["O","X"]
            ];

            $this->drawImage->current_image = [["O","X"],["O","X"],["O","X"]];
            $this->drawImage->drawVertical(2, 1, 2, "R");

            expect($this->drawImage->current_image)->toEqual($expected);
        });

        it('draws vertical line with color R from y=2 to y=3 in column 1', function () {
            $expected = [
                ["O","X"],
                ["R","X"],
                ["R","X"]
            ];

            $this->drawImage->current_image = [["O","X"],["O","X"],["O","X"]];
            $this->drawImage->drawVertical(1, 2, 3, "R");

            expect($this->drawImage->current_image)->toEqual($expected);
        });
    });

    describe('->drawHorizontal()', function () {
        it('draws horizontal line with color R from x=2 to x=3 in row 2', function () {
            $expected = [
                ["O","X","O"],
                ["O","R","R"],
                ["O","X","O"]
            ];

            $this->drawImage->current_image = [["O","X","O"],["O","X","O"],["O","X","O"]];
            $this->drawImage->drawHorizontal(2, 3, 2, "R");

            expect($this->drawImage->current_image)->toEqual($expected);
        });
    });

    // describe('->fillRegion()', function () {
    //     it('draws horizontal line with color R from x=2 to x=3 in row 2', function () {
    //         $expected = [
    //             ["O","O","O","O","O"],
    //             ["O","C","C","C","O"],
    //             ["O","C","O","C","O"],
    //             ["O","O","O","O","O"]
    //         ];

    //         $this->drawImage->current_image = [["O","O","O","O","O"],["O","R","R","R","O"],["O","R","O","R","O"],["O","O","O","O","O"]];
    //         $this->drawImage->fillRegion(2, 2, "C");

    //         expect($this->drawImage->current_image)->toEqual($expected);
    //     });
    // });
});
