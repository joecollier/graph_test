<?php
    namespace Editor\Helpers;

    require "vendor/autoload.php";

    class validateParams {
        protected $min_dimension = 1;
        protected $max_dimension = 250;

        protected function isValidDimension($value)
        {
            return (!($value < $this->min_dimension || $value > $this->max_dimension));
        }

        public function isValidDimensions($x, $y)
        {
            return $this->isValidDimension($x) && $this->isValidDimension($y);
        }
    }

    // class ioController {
    //     protected $current_image_state = [];

    //     public function __construct() {
    //         //$this->promptUser();
    //     }

    //     /* Prompts user for input continously until the session is terminated
    //      */
    //     function promptUser() {
    //         do {
    //             echo "Please enter a valid command: ";
    //             $input = rtrim(fgets(STDIN), "\n\r");
    //         } while ($this->parseUserInput($input));
    //     }

    //      Calls drawImage model and passes in params in order to generate and
    //      * display image
    //      *
    //      * @param string $input
    //      *
    //      * @return bool

    //     function handleInput($input)
    //     {
    //         $parsed_input = explode(" ", $input);

    //         $image = new drawImage;
    //         $image->run($parsed_input, $this->current_image_state);

    //         $this->current_image_state = $image->current_image;

    //         return true;
    //     }

    //     /* Users input will determine if the image needs to be drawn,
    //      * shown, or if the application should be terminated.
    //      *
    //      * @param string $input
    //      *
    //      * @return bool
    //      */
    //     function parseUserInput($input) {
    //         if (!is_string($input) || $input == "x") {
    //             return false;
    //         }

    //         return $this->handleInput($input);
    //     }
    // }

    // $obj = new ioController();
?>