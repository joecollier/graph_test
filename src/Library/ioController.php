<?php
    namespace Editor\Library;

    class ioController {
        public function __construct() {
            //$this->promptUser();
        }

        /* Prompts user for input continously until the session is terminated
         */
        function promptUser() {
            do {
                echo "Please enter a valid command: ";
                $input = rtrim(fgets(STDIN), "\n\r");
            } while ($this->parseUserInput($input));
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

            return true;
        }
    }
?>