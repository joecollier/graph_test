<?php
    namespace Editor\Library\Models;

    class drawImage {
        protected $current_image = [];

        public function __construct() {
            //$this->promptUser();
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
            return array_fill(0, $y, array_fill(0, $x, "O"));
        }

        public function clearImage()
        {
            $current_image_dimensions = $this->getCurrentImageDimensions();

            return $this->drawNewImage($current_image_dimensions['width'], $current_image_dimensions['height']);
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
            return [];
        }

        // /* Prompts user for input continously until the session is terminated
        //  */
        // protected function promptUser() {
        //     do {
        //         echo "Please enter a valid command: ";
        //         $input = rtrim(fgets(STDIN), "\n\r");       
        //     } while ($this->parseUserInput($input));
        // }

        //  Users input will determine if the image needs to be drawn,
        //  * shown, or if the application should be terminated.
        //  *
        //  * @param string $input
        //  *
        //  * @return bool
         
        // protected function parseUserInput($input) 
        // {
        //     if (!is_string($input) || $input == "x") {
        //         return false;
        //     }

        //     $this->handleUserInput($input);

        //     return true;
        // }

        // protected function handleUserInput($input) 
        // {
        //     echo "input";
        // }
    }
?>