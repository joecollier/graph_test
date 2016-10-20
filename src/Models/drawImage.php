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

    public $current_image;

    /**
     * Returns function name corresponding to input value or
     * false if no function is found
     *
     * @param string $command
     * @return mixed
     */
    protected function getFunctionName($command)
    {
        return isset($this->command_function_map[$command])
            ? $this->command_function_map[$command]
            : false;
    }

    /**
     * Returns current image object
     * @return Image $this->image
     */
    protected function getCurrentImage()
    {
        return $this->image;
    }

    /**
     * Sets current image object
     * @param Image $image
     */
    protected function setCurrentImage($image)
    {
        $this->current_image = $image;
    }

    /**
     * Creates a new image element with sets pixels
     *
     * @param string $x
     * @param string $y
     * @return Image
     */
    public function drawNewImage($x, $y)
    {
        $validator = new Validator;

        $is_valid = $validator->isValidDimensions($x, $y);

        if ($is_valid === true) {
            $this->image = new Image($x, $y);
            $this->setCurrentImage($this->image);

            return $this->image;
        }
    }

    /**
     * Function that takes users input and calls to functions in the Image class
     *
     * @param array $params
     * @param array $current_image
     * @return mixed
     */
    public function run($params, $current_image = [])
    {
        $function_name = $this->getFunctionName($params[0]);

        if (!isset($this->image)) {
            $this->image = $current_image;
        }

        if ($function_name) {
            $this->setCurrentImage($current_image);

            array_shift($params);

            try {
                if ($function_name == 'drawNewImage') {
                    call_user_func_array([$this, $function_name], $params);
                } else {
                    call_user_func_array([$this->image, $function_name], $params);
                }
            } catch(\Exception $e) {
                MessageHandler::outputError($e->getMessage());
            }

            return $this->getCurrentImage();
        } else {
            MessageHandler::output("Invalid command!");
        }

        return false;
    }
}
