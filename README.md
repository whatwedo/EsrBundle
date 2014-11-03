# whatwedoEsrBundle

Symfony2 bundle for creating [orange inpayment slip](https://www.postfinance.ch/en/biz/prod/pay/debsolution/inpayref/offer.html) PDF's

## Requirements

This library has the following requirements:

- PHP 5.3+

## Installation

install the library via composer:

```
composer require "whatwedo/esr-bundle:dev-master"
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

* see [/resources/docs](resources/docs/index.md)-folder for usage.
