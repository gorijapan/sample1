#! /usr/bin/php
<?php
require 'vendor/autoload.php';
use Symfony\Component\Yaml\Parser;


$dataFile = $argv[1];


$yaml = new Parser();
$data = $yaml->parse(file_get_contents($dataFile), false, false, true);
$json = json_encode($data);

echo $json;

