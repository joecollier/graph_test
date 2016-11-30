<?php
namespace Editor\App;

use Editor\App\App;

/**
 * App
 */
class App
{
    protected $io;

    public function __construct(\Editor\Controllers\IoController $controller)
    {
        $this->io_controller = $controller;
    }

    /**
     * Runs class responsible for handling user input/output
     */
    public function run()
    {
        $this->io_controller->promptUser();
    }
}
