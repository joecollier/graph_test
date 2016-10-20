<?php
namespace Editor\Models;

use Editor\Helpers\Validator;
use Editor\Controllers\MessageHandler;
use Editor\Models\Image;

/**
 * DrawImage
 */
class DrawImage
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

    // public $current_image = [];

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
        $image = $this->image->pixels;

        foreach ($image as $row) {
            foreach ($row as $pixel) {
                echo $pixel;
            }

            MessageHandler::output('');
        }
    }

    // protected function getCurrentImage()
    // {
    //     return $this->current_image;
    // }

    // protected function setCurrentImage($new_image)
    // {
    //     $this->current_image = $new_image;
    // }

    // protected function getCurrentImageDimensions()
    // {
    //     $current_image = $this->getCurrentImage();

    //     $height = count($current_image);
    //     $width = ($height > 0) ? count($current_image[0]) : 0;

    //     return [
    //         'width' => $width,
    //         'height' => $height
    //     ];
    // }

    public function drawNewImage($x, $y)
    {
        $validator = new Validator;

        $is_valid = $validator->isValidDimensions($x, $y);

        if ($is_valid === true) {
            // ////
            $this->image = new Image($x, $y);
            // foreach ($image_new->getImage()->pixels as $row) {
            //     var_dump(json_encode($row, true));
            // }
            // $image_new->getImageDimensions();
            // echo "\n\n";

            // $image_new->colorPixel(2, 2, "R");
            // foreach ($image_new->getImage()->pixels as $row) {
            //     var_dump(json_encode($row, true));
            // }
            // echo "\n\n";

            // $image_new->clearImage();
            // foreach ($image_new->getImage()->pixels as $row) {
            //     var_dump(json_encode($row, true));
            // }
            // echo "\n\n";

            // $image_new->drawVertical(2, 1, 3, "X");
            // foreach ($image_new->getImage()->pixels as $row) {
            //     var_dump(json_encode($row, true));
            // }
            // echo "\n\n";

            // $image_new->drawHorizontal(2, 3, 2, "R");

            // $image_new->displayDebug();
            // ////

            // return $image;
        } else {
            echo $is_valid;
        }
    }

    // public function clearImage()
    // {
    //     $current_image_dimensions = $this->getCurrentImageDimensions();

    //     return $this->drawNewImage(
    //         $current_image_dimensions['width'],
    //         $current_image_dimensions['height']
    //     );
    // }

    // public function colorPixel($x, $y, $c)
    // {
    //     $current_image = $this->getCurrentImage();

    //     // echo debug_backtrace()[1]['function'];
    //     // die();

    //     if (isset($current_image[$y]) &&
    //         isset($current_image[$y][$x]) &&
    //         $current_image[$y][$x]
    //     ) {
    //         $current_image[$y][$x] = $c;

    //         $this->setCurrentImage($current_image);
    //     } else {
    //         $error = sprintf(
    //             "Pixels selected to be colored is outside of the current image dimensions. [%s,%s]",
    //             $x,
    //             $y
    //         );

    //         throw new \Exception($error);
    //     }
    // }

    // public function drawVertical($x, $y1, $y2, $c)
    // {
    //     $current_image = $this->getCurrentImage();

    //     foreach ($current_image as $col_num => $row) {
    //         if ($col_num >= ($y1-1) && $col_num <= ($y2-1)) {
    //             $this->colorPixel(($x), $col_num+1, $c);
    //         }
    //     }
    // }

    // public function drawHorizontal($x1, $x2, $y, $c)
    // {
    //     $current_image = $this->getCurrentImage();

    //     foreach ($current_image[($y-1)] as $x_position => $pixel) {
    //         if ($x_position >= ($x1-1) && $x_position <= ($x2-1)) {
    //             $this->colorPixel(($x_position+1), $y, $c);
    //         }
    //     }
    // }

    // protected function fillAdjacent(
    //     $current_image,
    //     $x,
    //     $y,
    //     $target_color,
    //     $new_color,
    //     $x_max,
    //     $y_max
    // ) {
    //     if (isset($current_image[$x]) &&
    //         isset($current_image[$x][$y]) &&
    //         $current_image[$x][$y] == $target_color
    //     ) {
    //         $current_image[$x][$y] = $new_color;

    //         if ($x > 0) {
    //             $current_image = $this->fillAdjacent(
    //                 $current_image,
    //                 ($x-1),
    //                 $y,
    //                 $target_color,
    //                 $new_color,
    //                 $x_max,
    //                 $y_max
    //             );
    //         }

    //         if ($x < $x_max) {
    //             $current_image = $this->fillAdjacent(
    //                 $current_image,
    //                 ($x+1),
    //                 $y,
    //                 $target_color,
    //                 $new_color,
    //                 $x_max,
    //                 $y_max
    //             );
    //         }

    //         if ($y > 0) {
    //             $current_image = $this->fillAdjacent(
    //                 $current_image,
    //                 $x,
    //                 ($y-1),
    //                 $target_color,
    //                 $new_color,
    //                 $x_max,
    //                 $y_max
    //             );
    //         }

    //         if ($y < $y_max) {
    //             $current_image = $this->fillAdjacent(
    //                 $current_image,
    //                 $x,
    //                 ($y+1),
    //                 $target_color,
    //                 $new_color,
    //                 $x_max,
    //                 $y_max
    //             );
    //         }
    //     }

    //     return $current_image;
    // }

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

    public function run($params, $image = null)
    {
        $function_name = $this->getFunctionName($params[0]);

        if ($function_name) {
            array_shift($params);

            try {
                call_user_func_array([$this, $function_name], $params);

                var_dump($image);

            } catch(\Exception $e) {
                MessageHandler::outputError($e->getMessage());
            }

            return $this->image;
        } else {
            MessageHandler::output("Invalid command!");
        }

        return false;
    }
}
