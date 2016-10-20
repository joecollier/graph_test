<?php
namespace Editor\Models;

use Editor\Helpers\Validator;
use Editor\Controllers\MessageHandler;

/**
 * Image
 */
class Image
{
    public $pixels = [];
    protected $current_width = 0;
    protected $current_height = 0;
    protected $default_color = "O";

    public function __construct($width = 0, $height = 0)
    {
        $this->current_width = $width;
        $this->current_height = $height;

        $this->clearImage();

        // $this->pixels = [];
        // $this->pixels = array_fill(
        //     0,
        //     $height,
        //     array_fill(0, $width, $this->default_color)
        // );
    }

    public function getImageDimensions()
    {
        $width = $this->current_width;
        $height = $this->current_height;

        if ($height <= 0 || $width <= 0) {
            $height = count($this->pixels);
            $width = ($height > 0)
                ? count($this->pixels[0])
                : 0;
        }

        return [
            'width' => $width,
            'height' => $height
        ];
    }

    public function colorPixel($x, $y, $c)
    {
        $x += -1;
        $y += -1;

        if (isset($this->pixels[$y]) &&
            isset($this->pixels[$y][$x]) &&
            $this->pixels[$y][$x]
        ) {
            $this->pixels[$y][$x] = $c;
        } else {
            // $error = sprintf(
            //     "Pixels selected to be colored is outside of the current image dimensions. [%s,%s]",
            //     $x,
            //     $y
            // );

            // throw new \Exception($error);
        }
    }

    public function drawVertical($x, $y1, $y2, $c)
    {
        foreach ($this->pixels as $col_num => $row) {
            if ($col_num >= ($y1-1) && $col_num <= ($y2-1)) {
                $this->colorPixel(($x), $col_num+1, $c);
            }
        }
    }

    public function drawHorizontal($x1, $x2, $y, $c)
    {
        foreach ($this->pixels[($y-1)] as $x_position => $pixel) {
            // var_dump($x_position >= ($x1-1) && $x_position <= ($x2-1));
            // var_dump($x_position, ($x1-1), ($x2-1));
            // die();

            if ($x_position >= ($x1-1) && $x_position <= ($x2-1)) {
                $this->colorPixel(($x_position+1), $y, $c);
            }
        }
    }

    protected function fillAdjacent(
        $current_image,
        $x,
        $y,
        $target_color,
        $new_color,
        $x_max,
        $y_max
    ) {
        if (isset($current_image[$x]) &&
            isset($current_image[$x][$y]) &&
            $current_image[$x][$y] == $target_color
        ) {
            $current_image[$x][$y] = $new_color;

            if ($x > 0) {
                $current_image = $this->fillAdjacent(
                    $current_image,
                    ($x-1),
                    $y,
                    $target_color,
                    $new_color,
                    $x_max,
                    $y_max
                );
            }

            if ($x < $x_max) {
                $current_image = $this->fillAdjacent(
                    $current_image,
                    ($x+1),
                    $y,
                    $target_color,
                    $new_color,
                    $x_max,
                    $y_max
                );
            }

            if ($y > 0) {
                $current_image = $this->fillAdjacent(
                    $current_image,
                    $x,
                    ($y-1),
                    $target_color,
                    $new_color,
                    $x_max,
                    $y_max
                );
            }

            if ($y < $y_max) {
                $current_image = $this->fillAdjacent(
                    $current_image,
                    $x,
                    ($y+1),
                    $target_color,
                    $new_color,
                    $x_max,
                    $y_max
                );
            }
        }

        return $current_image;
    }

    public function fillRegion($x, $y, $new_color)
    {
        $target_color = $this->pixels[($x-1)][($y-1)];
        $dimensions = $this->getImageDimensions();

        $x_max = $dimensions['width'];
        $y_max = $dimensions['height'];

        $this->pixels = $this->fillAdjacent(
            $this->pixels,
            ($x-1),
            ($y-1),
            $target_color,
            $new_color,
            $x_max,
            $y_max
        );
    }

    public function clearImage()
    {
        $dimensions = $this->getImageDimensions();

        $this->pixels = array_fill(
            0,
            $dimensions['height'],
            array_fill(0, $dimensions['width'], $this->default_color)
        );
    }

    public function displayDebug()
    {
        foreach ($this->pixels as $row) {
            var_dump(json_encode($row, true));
        }
        echo "\n\n";
    }

    public function getImage()
    {
        return $this;
    }
}
