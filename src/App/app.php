<?php
    namespace Editor\App;
    use Editor\Controllers\ioController;

    require "vendor/autoload.php";

    class app {
        public function __construct() {
	    	$io = new ioController;
	    	$io->promptUser();
        }
    }

	$obj = new app();
?>