



```php

$result = Results::failure(['code' => 404, 'detail' => 'Not Found'])

$result->isFailure(); // true
$result->getError();  // 'Error 404: Not Found'


```php
$result = Results::success(42)

$result->getValue(); // 42 — callable is never invoked


```php
// Convert a raw exception into a structured error array
$result = Results::attempt(fn () => riskyOperation())
    ->mapError(fn (\Throwable $e) => [
        'message' => $e->getMessage(),
        'code'    => $e->getCode(),
    ]);
```
