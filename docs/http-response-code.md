# HTTP Response Codes

The `Result` pattern does not include a built-in `HttpResponseStatusCode` enum. You can use your framework's HTTP status constants (e.g. Symfony's `Response::HTTP_*`, Laravel's `Response::HTTP_*`) or PHP's native `http_response_code()` values directly as error payloads:

```php
use ArielEspinoza07\ResultPattern\Result;

// Store an HTTP status code as the error payload
$result = Result::failure(['status' => 404, 'message' => 'Not Found']);

// Or wrap any value you like
$result = Result::success(['status' => 200, 'data' => $payload]);
```

If you need a typed enum, define one in your own application:

```php
enum HttpStatus: int
{
    case Ok = 200;
    case NotFound = 404;
    case InternalServerError = 500;
}

$result = Result::failure(HttpStatus::NotFound);
```
