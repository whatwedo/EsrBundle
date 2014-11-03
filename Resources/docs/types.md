# Different Types

There are 4 different types of ISR:

## ESR boxed

* boxed number fields
* for direct PostFinance clients
* ```->setType(Configuration::ESR_BOXED)```

![ESR Boxed](../public/images/esr_boxed.jpg)

## ESR bordered

* same as ESR boxed, but with one, think border around the number field
* ```->setType(Configuration::ESR_BORDERED)```

![ESR Bordered](../public/images/esr_bordered.jpg)

## BESR boxed

* additional receiver field for post account of the client's bank
* ```setBank('UBS AG')->setBankCity('8001 Zürich')```
* ```->setType(Configuration::ESR_BOXED)```

![BESR Boxed](../public/images/besr_boxed.jpg)

## BESR bordered

* same as BESR boxed, but with one, think border around the number field
* ```->setType(Configuration::BESR_BORDERED)```

![BESR Bordered](../public/images/besr_bordered.jpg)


* [back to index](index.md)
