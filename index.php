<?php
require 'vendor/autoload.php';

use Guzzle\Http\Client;

// Create client object
$client = new Client(
	'http://.../{version}', [	// TODO: replace ... with your API URL
		'version' => 'v1'
	]
);

// Set all headers
$client->setDefaultOption(
	'headers', [
		'X-API-Secret' => '...' // TODO: replace ... with your API secret key
	]
);

// Get a product listing
$request = $client->get('product');
$response = $request->send();
var_dump($response->json());

// Get a product by id
$request = $client->get('product/1');
$response = $request->send();
var_dump($response->json());
