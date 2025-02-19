<?php


require_once("vendor/autoload.php");
require_once("define.php");


test_process();


use DB\fileReader;


$file_reader = new fileReader("./assets/test_process.xlsx", 0);

$file_reader->readFile();