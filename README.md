<h1 align="center">📮 Laravel API Responses</h1>

<p align="center">A Laravel package for building API responses in a normalized and easy to consume way.</p>

<p align="center">
    <a href="https://packagist.org/packages/igorsgm/laravel-api-responses">
        <img src="https://img.shields.io/packagist/v/igorsgm/laravel-api-responses.svg?style=flat-square" alt="Latest Version on Packagist">
    </a>
    <a href="https://travis-ci.org/igorsgm/laravel-api-responses">
        <img src="https://img.shields.io/scrutinizer/build/g/igorsgm/laravel-api-responses/master?style=flat-square" alt="Build Status">
    </a>
    <a href="https://scrutinizer-ci.com/g/igorsgm/laravel-api-responses">
        <img src="https://img.shields.io/scrutinizer/g/igorsgm/laravel-api-responses.svg?style=flat-square" alt="Quality Score">
    </a>
    <a href="https://packagist.org/packages/igorsgm/laravel-api-responses">
        <img src="https://img.shields.io/packagist/dt/igorsgm/laravel-api-responses.svg?style=flat-square" alt="Total Downloads">
    </a>
</p>

<hr/>

<p align="center">
    <img src="https://user-images.githubusercontent.com/14129843/110307757-2108d580-7fb4-11eb-9443-79ef14a12dd7.png" alt="API usage sample">
</p>

## ✨ Features

- `ApiResponse` Middleware to set the `Accept: application/json` header to your api routes and also throw exceptions as
  JSON.
- A list of macros that extend the Laravel's Response class, that can be easily used like `response()->success(...)`
- `_ide_helper_macros.php` file generated to improve your IDE's code completion

## 1️⃣ Installation

- You can install the package via composer:

```bash
composer require igorsgm/laravel-api-responses
```

- Publishing the config and IDE Helper files:

```bash
php artisan vendor:publish --provider="Igorsgm\LaravelApiResponses\LaravelApiResponsesServiceProvider"
```

## 2️⃣ Usage

First, register the `ApiResponse` at the top of your api middleware group, inside `app/Http/Kernel.php`.

``` php
class Kernel extends HttpKernel
{
    protected $middlewareGroups = [
        // ...
        'api' => [
            \Igorsgm\LaravelApiResponses\Http\Middleware\ApiResponse::class,
            // ...
        ],
    ];
    
    // ...
}
```

Now simply start using one of the available response functions to always return a normalized API data inside your controllers.
``` php
response()->success($data, $message) // ($data = [], $message = '', $status = 200, $headers = [])
response()->successMessage($message) // ($message = '', $status = 200, $headers = [])
response()->error($errors) // ($errors = [], $message = '', $status = 500, $headers = [])
response()->errorMessage($message) // ($message = '', $status = 500, $headers = [])
response()->exceptionError($exception) // ($exception, $message = '', $status = 0, $headers = [])
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email igor.sgm@gmail.com instead of using the issue tracker.

## Credits

- [Igor Moraes](https://github.com/igorsgm)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
