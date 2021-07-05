<?php
error_reporting(1);
include_once 'helpers/HttpHelper.php';
include_once 'helpers/global_function.php';
include_once 'helpers/connection.php';
include_once 'helpers/tanggal.php';
include_once 'helpers/alert.php';
include_once 'helpers/user.php';
include_once 'helpers/url.php';
include_once 'config/App.php';

session_start();

$app = new App();


echo $app->init();