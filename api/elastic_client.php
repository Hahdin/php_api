<?php
use Elasticsearch\ClientBuilder;
require '../vendor/autoload.php';
$hosts = [
    // This is equal to "http://localhost:9200/"
    [
        'host' => 'localhost', // Only host is required
    ],
];
$client = ClientBuilder::create() // Instantiate a new ClientBuilder
    ->setHosts($hosts) // Set the hosts
    ->build(); // Build the client object

