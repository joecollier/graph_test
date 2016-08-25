<?php
namespace Editor\App;

use Editor\App\App;

class App
{
    protected $io;

    public function __construct(ioController $controller)
    {
    	$this->io_controller = $controller;
    }

    public function run()
    {
    	$this->io_controller->promptUser();
    }
}
