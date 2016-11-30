<?php
namespace Editor\Models;

use kahlan\plugin\Stub;
use Editor\Models\Image;

describe('Image', function () {
    beforeEach(function () {
        $this->image = new Image(5, 5);
    });

    describe('->drawNewImage()', function () {
        it('returns x by y image populated with O', function () {
            $image = new Image(3, 4);

            $expected = [
                ["O","O","O"],
                ["O","O","O"],
                ["O","O","O"],
                ["O","O","O"]
            ];

            expect($image->pixels)->toEqual($expected);
        });

        it('returns image dimensions', function () {
            $width = 3;
            $height = 4;

            $image = new Image($width, $height);

            $expected = [
                'width' => 3,
                'height' => 4
            ];

            expect($image->getImageDimensions()['width'])->toEqual($expected['width']);
            expect($image->getImageDimensions()['height'])->toEqual($expected['height']);
        });
    });

    describe('->colorPixel()', function () {
        it('changes color value of element in array', function () {
            $this->image->colorPixel(2, 3, "R");
            $this->image->colorPixel(4, 1, "P");

            $expected = [
                ["O","O","O","P","O"],
                ["O","O","O","O","O"],
                ["O","R","O","O","O"],
                ["O","O","O","O","O"],
                ["O","O","O","O","O"]
            ];

            expect($this->image->pixels)->toEqual($expected);
        });
    });

    describe('->drawVertical()', function () {
        it('draws vertical line with color R from y=1 to y=2 in column 2', function () {
            $expected = [
                ["O","R"],
                ["O","R"],
                ["O","X"]
            ];

            $image = new Image(2, 3);
            $image->drawVertical(2, 1, 3, "X");
            $image->drawVertical(2, 1, 2, "R");

            expect($image->pixels)->toEqual($expected);
        });

        it('draws vertical line with color R from y=2 to y=3 in column 1', function () {
            $expected = [
                ["O","X"],
                ["R","X"],
                ["R","X"]
            ];

            $image = new Image(2, 3);
            $image->drawVertical(2, 1, 3, "X");
            $image->drawVertical(1, 2, 3, "R");

            expect($image->pixels)->toEqual($expected);
        });
    });

    describe('->drawHorizontal()', function () {
        it('draws horizontal line with color R from x=2 to x=3 in row 2', function () {
            $image = new Image(3, 3);

            $image->drawVertical(2, 1, 3, "X");
            $image->drawHorizontal(2, 3, 2, "R");

            $expected = [
                ["O","X","O"],
                ["O","R","R"],
                ["O","X","O"]
            ];

            expect($image->pixels)->toEqual($expected);
        });
    });

    describe('->fillRegion()', function () {
        it('fills region by changing all R pixels connected pixel at point 2,2 to the color C', function () {
            $image = new Image(5, 4);

            $image->colorPixel(2, 1, "R");
            $image->drawHorizontal(2, 4, 2, "R");
            $image->colorPixel(2, 3, "R");
            $image->colorPixel(4, 3, "R");
            $expected = [
                ["O","C","O","O","O"],
                ["O","C","C","C","O"],
                ["O","C","O","C","O"],
                ["O","O","O","O","O"]
            ];

            $image->fillRegion(2, 2, "C");

            expect($image->pixels)->toEqual($expected);
        });
    });
});
