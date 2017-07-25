# Phealthcheck

A HTTP health check library for PHP web applications.

## Installation

The easiest way to get started with Phealthcheck is to add it to your project 
using [Composer](https://getcomposer.org/):

```bash
composer require rickymcalister/phealthcheck
```

## Basic Usage

```php
try {
    // Build and run the health check
    $healthCheck = new Phealthcheck\HealthCheck([
        'database' => new Phealthcheck\Check\PdoStatusCheck(
            new PDO('dsn', 'dbuser', 'dbpass')
        )
    ]);
    $response = $healthCheck->getResponse();
} catch (Exception $e) {
    // Build and send a health check error response
    $response = HealthCheckError::getResponse($e->getMessage(), $e->getCode());
}

$response->send();
```

### Sample JSON Response

**Success**

```json
{
	"status": "OK",
	"database": "OK"
}
```

**Failure**

```json
{
	"status": "FAIL",
	"database": "FAIL"
}
```

**Error**

```json
{
	"status": "FAIL",
	"error": {
	    "message": "Some error message",
	    "code": 100
	}
}
```

## Contributing

TBC

### Running Tests

```bash
composer run test
```
