<?php
    namespace Editor\Models;

    class drawImage {
        protected $command_function_map = [
            "I" => 'drawNewImage',
            "C" => 'clearImage',
            "L" => 'colorPixel',
            "V" => 'drawVertical',
            "H" => 'drawHorizontal',
            "S" => 'showImage'
        ];

        public $current_image = [];
        protected $max_coordinate_size = 250;

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

        public function getPixelColor($x, $y)
        {
            return $this->getCurrentImage()[$y][$x];
        }

        public function colorPixel($x, $y, $c)
        {
            $current_image = $this->getCurrentImage();

            if (
                isset($current_image[$y]) &&
                isset($current_image[$y][$x]) &&
                $current_image[$y][$x]
            ) {
                $current_image[$y][$x] = $c;

                $this->setCurrentImage($current_image);
            } else {
                throw new \Exception(
                    "Pixel selected to be colored is outside of the image bounderies"
                );
            }
        }

        public function drawVertical($x, $y1, $y2, $c)
        {
            $current_image = $this->getCurrentImage();

            foreach ($current_image as $col_num => $row) {
                if ($col_num >= ($y1-1) && $col_num <= ($y2-1)) {
                    $this->colorPixel(($x-1), $col_num, $c);
                }
            }
        }

        public function drawHorizontal($x1, $x2, $y, $c)
        {
            $current_image = $this->getCurrentImage();

            foreach ($current_image[($y-1)] as $x_position => $pixel) {
                if ($x_position >= ($x1-1) && $x_position <= ($x2-1)) {
                    $this->colorPixel($x_position, ($y-1), $c);
                }
            }
        }

        protected function inRange($x, $y)
        {
            if (isset($this->current_image[$x]) && isset($this->current_image[$x][$y])) {
                return true;
            }

            return false;
        }

        public function fillRegion($x, $y, $c, $base_color = '')
        {
            $base_color = ($base_color > '')
                ? $base_color
                : $this->getPixelColor($x-1, $y-1);

            if ($this->getPixelColor($x-1, $y-1) == $base_color && $this->inRange($x, $y)) {
                $this->colorPixel($x-1, $y-1, $c);

                // $this->fillRegion($x, $y-1, $c, $base_color);
                // $this->fillRegion($x-2, $y-1, $c, $base_color);
                // $this->fillRegion($x-1, $y, $c, $base_color);
                // $this->fillRegion($x-1, $y-2, $c, $base_color);
            }
        }

        protected function validateCoords($x, $y)
        {
            if ($x < $this->max_coordinate_size && $y < $this->max_coordinate_size) {
                return true;
            }

            return false;
        }

        public function run($params, $current_image = [])
        {
            $function_name = $this->getFunctionName($params[0]);

            if ($function_name) {
                if ($this->validateCoords($params[1], $params[2])) {
                    $this->setCurrentImage($current_image);

                    array_shift($params);
                    call_user_func_array([$this, $function_name], $params);

                    return $this->getCurrentImage();
                } else {
                    echo "Please enter dimensions less than {$this->max_coordinate_size}\n";
                }
            } else {
                echo "Invalid command!\n";
            }

            return false;
        }
    }
?>