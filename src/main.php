<?php
namespace Editor;
use Editor\App\App;
use Editor\Controllers\ioController;

require "vendor/autoload.php";

$app = new App(new ioController());
$app->run();
