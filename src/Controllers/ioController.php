<?php
    namespace Editor\Controllers;

    require "vendor/autoload.php";

    use Editor\Models\drawImage;

    // $loader = require 'vendor/autoload.php';
    // $loader->add('Models', '/../src/Models');

    class ioController {
        protected $input_command_map = [
            "I" => 'drawNewImage',
            "C" => 'clearImage',
            "L" => 'colorPixel',
            "V" => 'drawVertical',
            "H" => 'drawHorizontal',
            "S" => 'showImage'
        ];

        public function __construct() {
            $this->promptUser();
        }

        /* Prompts user for input continously until the session is terminated
         */
        function promptUser() {
            do {
                echo "Please enter a valid command: ";
                $input = rtrim(fgets(STDIN), "\n\r");
            } while ($this->parseUserInput($input));
        }

        function getInputFunction($command)
        {
            return isset($this->input_command_map[$command])
                ? $this->input_command_map[$command]
                : false;
        }

        function handleInput($input)
        {
            $parsed_input = explode(" ", $input);

            $input_function = $this->getInputFunction($parsed_input[0]);

            if ($input_function) {
                $image = new drawImage($input_function, $parsed_input);

                foreach ($image as $row) {
                    // foreach ($row as $n) {
                    //     echo $n;
                    // }
                }
            }

            var_dump($input_function);
        }

        /* Users input will determine if the image needs to be drawn,
         * shown, or if the application should be terminated.
         *
         * @param string $input
         *
         * @return bool
         */
        function parseUserInput($input) {
            if (!is_string($input) || $input == "x") {
                return false;
            }

            $this->handleInput($input);

            return true;
        }
    }

    $obj = new ioController();
?>