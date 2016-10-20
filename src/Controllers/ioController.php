<?php
namespace Editor\Controllers;

use Editor\Models\drawImage;
use Editor\Controllers\MessageHandler;

class IoController
{
    // protected $current_image_state = [];

    /* Calls drawImage model and passes in params in order to generate and
     * display image
     *
     * @param string $input
     * @return bool
     */
    private function handleInput($input)
    {
        $parsed_input = explode(" ", $input);

        $drawImage = new drawImage();
        $this->image = $drawImage->run($parsed_input, $this->image);

        // $this->current_image_state = $image->pixels;

        return true;
    }

    /* Users input will determine if the image needs to be drawn,
     * shown, or if the application should be terminated.
     *
     * @param string $input
     * @return bool
     */
    private function parseUserInput($input)
    {
        if ($input == "X") {
            MessageHandler::output("terminating...");
            return false;
        } elseif (!is_string($input)) {
            return false;
        }

        return $this->handleInput($input);
    }

    /* Prompts user for input continously until the session is terminated
     */
    public function promptUser()
    {
        do {
            MessageHandler::output("Please enter command: ");
            $input = rtrim(fgets(STDIN), "\n\r");
        } while ($this->parseUserInput($input));
    }
}
