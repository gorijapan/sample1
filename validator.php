#! /usr/bin/php
<?php
require 'vendor/autoload.php';

$schemaFile = $argv[1];
$dataFile = $argv[2];


// Get the schema and data as objects
$retriever = new \JsonSchema\Uri\UriRetriever;
$schema = $retriever->retrieve('file://' . realpath($schemaFile));
$data = json_decode(file_get_contents($dataFile));

// If you use $ref or if you are unsure, resolve those references here
// This modifies the $schema object
$refResolver = new \JsonSchema\RefResolver($retriever);
$refResolver->resolve($schema, 'file://' . __DIR__);

// Validate
$validator = new \JsonSchema\Validator();
$validator->check($data, $schema);

if ($validator->isValid()) {
    echo "isValid! The supplied JSON validates against the schema.\n";
} else {
    echo "JSON does not validate. Violations:\n";
    foreach ($validator->getErrors() as $error) {
        echo sprintf("[%s] %s\n", $error['property'], $error['message']);
    }
}
