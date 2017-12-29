## Laravel 5 REST API Core

### Install

Require this package with composer using the following command:

```bash
composer require evgeny-l/rest-api-core
```

After updating composer, add the service provider to the `providers` array in `config/app.php`

```php
EvgenyL\RestAPICore\RestAPICoreServiceProvider::class,
```

Publish the config file to `config/rest-api-core.php`

```bash
php artisan vendor:publish --provider="EvgenyL\RestAPICore\RestAPICoreServiceProvider" --tag=config
```

Install exceptions handler to `app/Exceptions/Handler.php`:

```
use EvgenyL\RestAPICore\Http\Exceptions\APIJSONHandlerTrait;

...
    public function render($request, Exception $exception)
    {
        if ($request->expectsJson()) {
            return $this->handleJSONResponse($request, $exception);
        }
        return parent::render($request, $exception);
    }
    
...
```

Install response middleware for JSON formatting into API middleware section:

```
\EvgenyL\RestAPICore\Http\Middleware\ResponseFormat::class
```