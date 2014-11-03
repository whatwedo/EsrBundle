# Add IPS Background

If you want to show your clients how they need to fill out the IPS, you can add a IPS background to the PDF. 

```php
$configuration = (new Configuration())
    ->setType(Configuration::TYPE_BESR_BORDERED)
    ->setReceiver('whatwedo GmbH')
    ->setReceiverAddress('Theaterplatz 2')
    ->setReceiverCity('3011 Bern')
    ->setSender('Max Muster')
    ->setSenderAddress('Musterstrasse 2')
    ->setSenderCity('3014 Bern')
    ->setReceiverAccount('01-165-2')
    ->setAmount(394975) // float * 100
    ->setReferenceNumber('22100305560000144678') // without check digit!
    ->setEsrBackground() // adds the background
;

/** @var EsrManager $esrManager */
$esrManager = $this->getContainer()->get('whatwedo_esr.manager');

return $esrManager->getPdfResponse($configuration);
// alternative: $esrManager->writePdfOutput('~/esr.pdf', $configuration);
```

* [back to index](index.md)
