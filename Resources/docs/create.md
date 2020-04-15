# Create An Orange Inpayment Slip PDF

without background, to print directly on A4 ISR-paper

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
    ->setCustomerIdentificationNumber('123456') // bank issued customer id (max 6 chars)
    ->setReferenceNumber('22100305560000144678') // without check digit! (max 20 chars)
;

/** @var EsrManager $esrManager */
$esrManager = $this->getContainer()->get('whatwedo_esr.manager');

return $esrManager->getPdfResponse($configuration);
// alternative: $esrManager->writePdfOutput('~/esr.pdf', $configuration);
```

* [back to index](index.md)

