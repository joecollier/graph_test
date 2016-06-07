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

        public function __construct()
        {

        }

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

            return $this->drawNewImage($current_image_dimensions['width'], $current_image_dimensions['height']);
        }

        public function getPixelColor($x, $y)
        {
            return $this->getCurrentImage()[$y][$x];
        }

        public function colorPixel($x, $y, $c)
        {
            $current_image = $this->getCurrentImage();

            if (isset($current_image[$y]) && isset($current_image[$y][$x]) && $current_image[$y][$x]) {
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

        public function fillRegion($x, $y, $c)
        {
            $current_image = $this->getCurrentImage();

            var_dump($current_image);

            $target_color = $this->getPixelColor(($x-1), ($y-1));

            var_dump($target_color);

            // var_export($current_image);
            // var_dump(sizeof($current_image));

            $y_size = sizeof($current_image);

            $x = 0;

            foreach ($current_image[0] as $x_val) {
                $x++;
                $x_size = $x;
            }

            var_dump($x_size, $y_size);

            die();

            // $base_color = $this->getPixelColor($x-1, $y-1);

            // $this->colorPixel($x-1, $y-1, $c);
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
    }
?>