Ruiljekleertjes API
===================

The Ruiljekleertjes REST API can be used to get access to the Ruiljekleertjes database. To get you started, I've set up
an example PHP client using [Guzzle](https://github.com/guzzle/guzzle) to perform some basic API calls.


```php
use Guzzle\Http\Client;

// Create client object
$client = new Client(
	'http://.../{version}', [
		'version' => 'v1'
	]
);

// Get a product listing
$request = $client->get('product');
$response = $request->send();
```

Installation
------------
```bash
# clone repository in current path
git clone https://github.com/lsdevries/ruiljekleertjes-client ./

# run composer install
composer install
```

API HTTP routes
--------------
 Action           | Route
 -----------------|--------------
 List records     | `GET` `/resource`
 Get one records  | `GET` `/resource/:resourceId`
 Create a record  | `POST` `/resource`
 Update a record  | `PUT` `/resource/:resourceId`
 Delete a record  | `DELETE` `/resource/:resourceId`

The result of a list API call can contain the following properties:
* `pagination` an object containing `per_page` `total_pages` `total_objects` properties for paginating large data sets;
* `data` an object or array containing the data you're looking for. Some objects are nested with other objects;

The result of the `POST` `PUT` `DELETE` routes contain a property describing the result:
* `message` a string describing the end result of a `POST` `PUT` `DELETE` actions;

Authentication
--------------
To get access to the API add your API secret key to the HTTP header property `X-API-Secret`. An incorrect value will result in a `403` error.

For some operations, you also need to be a registered user. Authentication works with [laravel-auth-token](https://github.com/bytesflipper/laravel-auth-token).
Perform an `POST` call to `/user/login` with `email` and `password` to retrieve a `token` which you can add to the `X-Aut-Token` HTTP header property.

Resources
---------
The following resources are at your disposal:

1. user
2. product
 - age
 - brand
 - category
 - condition
 - gender
 - image
 - size
3. messagethread
 - message
4. shop
5. ad

Most resources are read-only. For other resources to be able to perform POST / PUT and DELETE calls, you need to be authenticated.

### User ###

Route | Description | Parameters
------|-------------|--------------------
`GET` `/user/:userId` | Get a user | `id`
`POST` `/user` | Register a new user | `name` `email` `password` `password_confirmation`
`POST` `/user/login` | Authenticate user | `email` `password` |
`POST` `user/sendpasswordreminder` | Send password reminder to user's email address | `email` |
`PUT` `/user/:userId` | Update the auth user* | `name` `email` `password` `password_confirmation`
`PUT` `/follow/:userId` | Auth user toggle follow another user* | `id`
`GET` `/user/:userId/follows` | Get a list of users followed by user | `id`
`GET` `/user/:userId/followers` | Get a list of users following user | `id`
`DELETE` `/user/:userId` | Delete the auth user* | `id`

*) login required

### Product ###

Route | Description | Parameters
------|-------------|--------------------
`GET` `/product` | List products | `search` (optional. Searches in: `name` `description` `category` `brand` `user` product properties) `user_id` (optional. Only list user's products)
`GET` `/product/:productId` | Get a product | `id`
`POST` `/product` | Create a new product by auth user | `images` (array containing 1 image **) `name` `description` `gender_id` `age_id` `size_id` `category_id` `brand_id` `condition_id`
`PUT` `/product/:productId` | Update a product by auth user | (same as `POST` `/product`)
`PUT` `/product/:productId/like` | Auth user toggle like product* | `id`

**) When uploading images the `images` parameter should be an array of image objects with one key `imageData` with
base64 encoded image data. `[0 => ['imageData' => '<image data>']]`. At this moment just one image per product is supported.

### Age, brand, category, condition, gender, size ###

Route | Description | Parameters
------|-------------|--------------------
`GET` `/category` | List ages | `search` (optional. Searches in: `name` property. Only available for `brand` resource)
`GET` `/category/:categoryId` | Get an age | `id`

### Messagethread ###

Route | Description | Parameters
------|-------------|--------------------
`GET` `/messagethread` | List auth user's message threads filtered by product or other user | `product_id` `user_id`
`GET` `/messagethread` | View and if not exists create message thread and list its messages | `product_id` `user_id` `add_if_not_found`*** `with_messages` `mark_read`
`GET` `/messagethread/:messagethreadId` | View message thread and list its messages | `with_messages` `mark_read`

***) `add_if_not_found` `with_messages` `mark_read` are booleans containing the string 'yes' (`true`) or something else (`false`)

### Messages ###

Route | Description | Parameters
------|-------------|--------------------
`POST` `/message` | Add new message to messagethread_id for auth user | `messagethread_id` `content` `product_id`

****) `product_id` (optional) point message to product to show product image in chat. `content` is not visible in chat when `product_id` is set.
