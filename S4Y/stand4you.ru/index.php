<?php
require_once dirname(__FILE__) . '/../application/Application.php';

$app = new Application();
$app->serve($_SERVER['REDIRECT_URL']);
