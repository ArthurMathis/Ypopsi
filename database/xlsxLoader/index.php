<?php


require_once("vendor/autoload.php");
require_once("define.php");


test_process();
env_start();


use DB\FileManip\fileReader;


$file_reader = new fileReader("./assets/test_process.xlsx", 0);

$file_reader->readFile();

echo "<h1>Processus terminé</h1>";