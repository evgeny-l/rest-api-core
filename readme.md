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
