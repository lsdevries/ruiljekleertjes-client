Ruiljekleertjes API
===================

The Ruiljekleertjes API can be used to get access to the Ruiljekleertjes database. To get you started, I've set up an
example PHP client using [Guzzle](https://github.com/guzzle/guzzle) which performs some basic API calls.

```ruby
require 'redcarpet'
markdown = Redcarpet.new("Hello World!")
puts markdown.to_html
```


```php
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
```


