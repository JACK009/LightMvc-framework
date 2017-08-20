<?php
require_once '../App/LightMvc/Core/App.php';
define('ROOTDIRECTORY', __DIR__);
$app = \App\LightMvc\Core\App::getInstance();
$app->run();