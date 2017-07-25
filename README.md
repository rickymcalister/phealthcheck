# Phealthcheck

A HTTP health check library for PHP web applications.

## Installation

Use Composer

```bash
./composer.phar require rickymcalister/phealthcheck
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

### Example JSON Response

```json
{
	"status": "OK",
	"database": "OK"
}
```

## Running Tests

```bash
./composer.phar run test
```
