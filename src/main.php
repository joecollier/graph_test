<?php
namespace Editor;

use Editor\App\App;
use Editor\App\JsonData;
use Editor\Controllers\IoController;

require "vendor/autoload.php";

$app = new App(new IoController());
$app->run();
