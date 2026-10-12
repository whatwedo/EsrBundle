# whatwedoEsrBundle

Symfony2 bundle for creating [orange inpayment slip](https://www.postfinance.ch/en/biz/prod/pay/debsolution/inpayref/offer.html)
and [QR invoices](https://www.paymentstandards.ch/dam/downloads/ig-qr-bill-en.pdf) PDF's

## Requirements

This library has the following requirements:

- PHP 5.3+
- wkhtmltopdf 

## Installation

install the library via composer:

```
composer require "whatwedo/esr-bundle"
```

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...

        new whatwedo\EsrBundle\whatwedoEsrBundle(),
    );
}
```

## Documentation

* see [/Resources/docs](Resources/docs/index.md)-folder for usage.

## Development

The tests render PDFs and need wkhtmltopdf, which the Docker image provides. With [dde](https://github.com/whatwedo/dde):

```
dde project:up
dde project:exec -- composer update --prefer-stable
dde project:exec vendor/bin/phpunit
```

Without dde:

```
docker compose run --rm php composer update --prefer-stable
docker compose run --rm php vendor/bin/phpunit
```
