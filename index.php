<?php
require 'vendor/autoload.php';

use Guzzle\Http\Client;

// Create client object
$client = new Client(
	'http://localhost/ruiljekleertjes/api/public/{version}', [
		'version' => 'v1'
	]
);

// Get a product listing
$request = $client->get('product');
$response = $request->send();

$request = $client->get('product/580');
$response = $request->send();
var_dump($response->json());
