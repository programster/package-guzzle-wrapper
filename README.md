Guzzle Wrapper
===============
A library that wraps around Guzzle in order to make it easier to send HTTP requests.
If you need to do anything more complicated, then you can just get the guzzle objects within.

## Example Usage

```php
$request = new Programster\GuzzleWrapper\Request(
    Programster\GuzzleWrapper\Method::createGet(),
    'http://my.domain.com',
    ['hello' => 'world']
);

// send the request to get a response
$response = $request->send();

// If we were sending to an API, then we want to json_decode the response
$jsonResponseObject = json_decode($response->getBody());
```

Switching to a POST/PUT/DELETE is a one line change. E.g.
```php
$request = new Programster\GuzzleWrapper\Request(
    Programster\GuzzleWrapper\Method::createPost(),
    'http://my.domain.com',
    ['hello' => 'world']
);
```



## Testing
Go to the tests folder and run:

```bash
php -S localhost:80 RequestDumper.php
```

Then execute the tests with:
```bash
php main.php
```

This should simply tell you whether each test passed or not.
