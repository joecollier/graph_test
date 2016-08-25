<?php
namespace Editor\Models;
use Editor\Helpers\Validator;

require "vendor/autoload.php";

class drawImage
{
    protected $command_function_map = [
        "I" => 'drawNewImage',
        "C" => 'clearImage',
        "L" => 'colorPixel',
        "V" => 'drawVertical',
        "H" => 'drawHorizontal',
        "S" => 'showImage',
        "F" => 'fillRegion'
    ];

    public $current_image = [];

    /* Returns function name corresponding to input value or
     * false if no function is found
     *
     * @param string $command
     *
     * @return mixed
     */
    protected function getFunctionName($command)
    {
        return isset($this->command_function_map[$command])
            ? $this->command_function_map[$command]
            : false;
    }

    protected function showImage()
    {
        $image = $this->getCurrentImage();

        foreach ($image as $row) {
            foreach ($row as $pixel) {
                echo $pixel;
            }

            echo "\n";
        }
    }

    protected function getCurrentImage()
    {
        return $this->current_image;
    }

    protected function setCurrentImage($new_image)
    {
        $this->current_image = $new_image;
    }

    protected function getCurrentImageDimensions()
    {
        $current_image = $this->getCurrentImage();

        $height = count($current_image);
        $width = ($height > 0) ? count($current_image[0]) : 0;

        return [
            'width' => $width,
            'height' => $height
        ];
    }

    public function drawNewImage($x, $y)
    {
        $image = array_fill(0, $y, array_fill(0, $x, "O"));
        $this->setCurrentImage($image);

        return $image;
    }

    public function clearImage()
    {
        $current_image_dimensions = $this->getCurrentImageDimensions();

        return $this->drawNewImage(
            $current_image_dimensions['width'],
            $current_image_dimensions['height']
        );
    }

    public function colorPixel($x, $y, $c)
    {
        $x = ($x-1);
        $y = ($y-1);

        $current_image = $this->getCurrentImage();

        if (
            isset($current_image[$y]) &&
            isset($current_image[$y][$x]) &&
            $current_image[$y][$x]
        ) {
            $current_image[$y][$x] = $c;

            $this->setCurrentImage($current_image);
        } else {
            throw new \Exception("Pixel selected to be colored is outside of the image bounderies");
        }
    }

    public function drawVertical($x, $y1, $y2, $c)
    {
        $current_image = $this->getCurrentImage();

        foreach ($current_image as $col_num => $row) {
            if ($col_num >= ($y1-1) && $col_num <= ($y2-1)) {
                $this->colorPixel(($x), $col_num+1, $c);
            }
        }
    }

    public function drawHorizontal($x1, $x2, $y, $c)
    {
        $current_image = $this->getCurrentImage();

        foreach ($current_image[($y-1)] as $x_position => $pixel) {
            if ($x_position >= ($x1-1) && $x_position <= ($x2-1)) {
                $this->colorPixel(($x_position+1), $y, $c);
            }
        }
    }

    protected function getCoordinates($x, $y, $x_max, $y_max)
    {
        $coordinates = [];

        if ($x > 0) {
            $coordinates[] = [
                'x' => $x - 1,
                'y' => $y
            ];
        } elseif ($x < $x_max) {
            $coordinates[] = [
                'x' => $x + 1,
                'y' => $y
            ];
        } elseif ($y > 0) {
            $coordinates[] = [
                'x' => $x,
                'y' => $y - 1
            ];
        } elseif ($y < $y_max) {
            $coordinates[] = [
                'x' => $x,
                'y' => $y +1
            ];
        }

        return $coordinates;
    }

    protected function fillAdjacent(array $current_image, $x, $y, $target_color, $new_color, $x_max, $y_max)
    {
        if (
            isset($current_image[$x]) &&
            isset($current_image[$x][$y]) &&
            $current_image[$x][$y] == $target_color
        ) {
            $current_image[$x][$y] = $new_color;

            $coordinates = $this->getCoordinates($x, $y, $x_max, $y_max);

            foreach ($coordinates as $coordinate) {
                $current_image = $this->fillAdjacent(
                    $current_image,
                    $coordinate['x'],
                    $coordinate['y'],
                    $target_color,
                    $new_color,
                    $x_max,
                    $y_max
                );
            }

            /*if ($x > 0) {
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
            }*/
        }

        return $current_image;
    }

    public function fillRegion($x, $y, $new_color)
    {
        $current_image = $this->getCurrentImage();

        $target_color = $current_image[($x-1)][($y-1)];

        $dimensions = $this->getCurrentImageDimensions();

        $x_max = $dimensions['width'];
        $y_max = $dimensions['height'];

        $this->current_image = $this->fillAdjacent(
            $current_image,
            ($x-1),
            ($y-1),
            $target_color,
            $new_color,
            $x_max,
            $y_max
        );
    }

    public function run($params, $current_image = [])
    {
        $function_name = $this->getFunctionName($params[0]);

        if ($function_name) {
            $this->setCurrentImage($current_image);

            array_shift($params);
            call_user_func_array([$this, $function_name], $params);

            return $this->getCurrentImage();
        } else {
            echo "Invalid command!\n";
        }

        return false;
    }

    /*public function run($params, $current_image = [])
    {
        $function_name = $this->getFunctionName($params[0]);

        if (!$function_name) {
            echo "Invalid command!\n";
            return false;
        }

        $this->setCurrentImage($current_image);

        array_shift($params);
        $this->$function_name($params);

        return $this->getCurrentImage();
    }*/
}
