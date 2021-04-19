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
