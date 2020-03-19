<?php
/*
 * Copyright (c) 2014, whatwedo GmbH
 * All rights reserved
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright notice,
 *    this list of conditions and the following disclaimer.
 *
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 *    this list of conditions and the following disclaimer in the documentation
 *    and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
 * IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT,
 * INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT
 * NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
 * PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY,
 * WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */

namespace whatwedo\EsrBundle\Configuration;

 use Sprain\SwissQrBill\DataGroup\Element\AdditionalInformation;
 use Sprain\SwissQrBill\DataGroup\Element\AlternativeScheme;
 use Sprain\SwissQrBill\DataGroup\Element\CombinedAddress;
 use Sprain\SwissQrBill\DataGroup\Element\CreditorInformation;
 use Sprain\SwissQrBill\DataGroup\Element\PaymentAmountInformation;
 use Sprain\SwissQrBill\DataGroup\Element\PaymentReference;
 use Sprain\SwissQrBill\QrBill;
 use Sprain\SwissQrBill\Reference\QrPaymentReferenceGenerator;
 use Symfony\Component\Validator\ConstraintViolationListInterface;

 /**
 * @author Ueli Banholzer <ueli@whatwedo.ch>
 */
class Configuration
{
    const TYPE_ESR_BOXED     = 1;
    const TYPE_ESR_BORDERED  = 2;
    const TYPE_BESR_BOXED    = 4;
    const TYPE_BESR_BORDERED = 8;
    const TYPE_QR            = 16;

    // on A4 bottom
    const FORMAT_A4 =  'A4';

    // on A5 landscape bottom
    const FORMAT_A5 = 'A5';

    // esr only
    const FORMAT_ESR = 'ESR';

    const REF_QRR = PaymentReference::TYPE_QR;

    const REF_SCOR = PaymentReference::TYPE_SCOR;

    /**
     * @var string s
     */
    protected $format = self::FORMAT_A4;

    /**
     * @var int ESR-Typ
     */
    protected $type = self::TYPE_ESR_BOXED;

    /**
     * @var string Reference type
     */
    protected $ref = self::REF_QRR;

    /**
     * @var string «Einzahlung für» (BESR) Bank-Name
     */
    protected $bank = '';

    /**
     * @var string «Einzahlung für» (BESR) Bank-PLZ/Ort
     */
    protected $bankCity = '';

    /**
     * @var string «Einzahlung für» (ESR) / «Zugunsten von» (BESR) Name
     */
    protected $receiver = '';

    /**
     * @var string «Einzahlung für» (ESR) / «Zugunsten von» (BESR) Adresse
     */
    protected $receiverAddress = '';

    /**
     * @var string «Einzahlung für» (ESR) / «Zugunsten von» (BESR) Adresszusatz
     */
    protected $receiverAdditional = '';

    /**
     * @var string «Einzahlung für» (ESR) / «Zugunsten von» (BESR) PLZ / Ort
     */
    protected $receiverCity = '';

    /**
     * @var string 2 stelliger ISO Länder Code
     */
    protected $receiverCountry = 'CH';

    /**
     * @var string Konto-Nummer (01-XXX-XX)
     */
    protected $receiverAccount = '';

    /**
     * @var string IBAN
     */
    protected $receiverAccountIBAN = '';

    /**
     * @var int Betrag
     */
    protected $amount = 0;

    /**
     * @var string Währung
     */
    protected $currency = 'CHF';

    /**
     * @var string «Einbezahlt von» Name
     */
    protected $sender = '';

    /**
     * @var string «Einbezahlt von» Adresse
     */
    protected $senderAddress = '';

    /**
     * @var string «Einbezahlt von» Adresszusatz
     */
    protected $senderAdditional = '';

    /**
     * @var string «Einbezahlt von» PLZ / Ort
     */
    protected $senderCity = '';

    /**
     * @var string 2 stelliger ISO Länder Code
     */
    protected $senderCountry = 'CH';

    /**
     * @var string Referenznummer (inkl. Prüfziffer)
     */
    protected $referenceNumber = '';

    /**
     * @var int from your bank
     */
    protected $customerIdentificationNumber = 0;

    /**
     * @var bool Soll ESR-Hintergrund gedruckt werden?
     */
    protected $esrBackground = false;

    /**
     * @var string
     */
    protected $message = '';

    /**
     * @var string
     */
    protected $billingInfo = '';

    /**
     * @var string[]
     */
    protected $alternativeSchemes = [];

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @param string $format
     */
    public function setFormat(string $format): Configuration
    {
        $this->format = $format;
        return $this;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $type
     * @return Configuration
     */
    public function setType(int $type): Configuration
    {
        $this->type = $type;

        return $this;
    }

    public function isBesr()
    {
        return $this->getType() === Configuration::TYPE_BESR_BORDERED
            || $this->getType() === Configuration::TYPE_BESR_BOXED;
    }

    public function isBoxed()
    {
        return $this->getType() === Configuration::TYPE_ESR_BOXED
            || $this->getType() === Configuration::TYPE_BESR_BOXED;
    }

    public function isQr()
    {
        return $this->getType() === Configuration::TYPE_QR;
    }

    /**
     * @return string
     */
    public function getBank()
    {
        return $this->bank;
    }

    /**
     * @param string $bank
     * @return Configuration
     */
    public function setBank(string $bank): Configuration
    {
        $this->bank = $bank;

        return $this;
    }

    /**
     * @return string
     */
    public function getBankCity()
    {
        return $this->bankCity;
    }

    /**
     * @param string $bankCity
     * @return Configuration
     */
    public function setBankCity($bankCity): Configuration
    {
        $this->bankCity = $bankCity;

        return $this;
    }

    /**
     * @return string
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @param string $receiver
     * @return Configuration
     */
    public function setReceiver(string $receiver): Configuration
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * @return string
     */
    public function getReceiverAddress()
    {
        return $this->receiverAddress;
    }

    /**
     * @param string $receiverAddress
     * @return Configuration
     */
    public function setReceiverAddress(string $receiverAddress): Configuration
    {
        $this->receiverAddress = $receiverAddress;

        return $this;
    }

    /**
     * @return string
     */
    public function getReceiverAdditional()
    {
        return $this->receiverAdditional;
    }

    /**
     * @param string $receiverAdditional
     * @return Configuration
     */
    public function setReceiverAdditional(string $receiverAdditional): Configuration
    {
        $this->receiverAdditional = $receiverAdditional;

        return $this;
    }

    /**
     * @return string
     */
    public function getReceiverCity()
    {
        return $this->receiverCity;
    }

    /**
     * @param string $receiverCity
     * @return Configuration
     */
    public function setReceiverCity(string $receiverCity): Configuration
    {
        $this->receiverCity = $receiverCity;

        return $this;
    }

    /**
     * @return string
     */
    public function getReceiverCountry()
    {
        return $this->receiverCountry;
    }

    /**
     * @param string $receiverCountry
     * @return Configuration
     */
    public function setReceiverCountry(string $receiverCountry): Configuration
    {
        $this->receiverCountry = $receiverCountry;

        return $this;
    }

    /**
     * @return string
     */
    public function getReceiverAccount()
    {
        return $this->receiverAccount;
    }

    /**
     * @param string $receiverAccount
     * @return Configuration
     */
    public function setReceiverAccount(string $receiverAccount): Configuration
    {
        $this->receiverAccount = $receiverAccount;

        return $this;
    }

    /**
     * @return string
     */
    public function getReceiverAccountIBAN()
    {
        return $this->receiverAccountIBAN;
    }

    /**
     * @param string $receiverAccountIBAN
     * @return Configuration
     */
    public function setReceiverAccountIBAN(string $receiverAccountIBAN): Configuration
    {
        $this->receiverAccountIBAN = $receiverAccountIBAN;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @return Configuration
     *
     * amount in cents
     */
    public function setAmount(int $cents): Configuration
    {
        $this->amount = $cents;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     * @return Configuration
     */
    public function setCurrency(string $currency): Configuration
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return string
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param string $sender
     * @return Configuration
     */
    public function setSender(string $sender): Configuration
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * @return string
     */
    public function getSenderAddress()
    {
        return $this->senderAddress;
    }

    /**
     * @param string $senderAddress
     * @return Configuration
     */
    public function setSenderAddress(string $senderAddress): Configuration
    {
        $this->senderAddress = $senderAddress;

        return $this;
    }

    /**
     * @return string
     */
    public function getSenderAdditional()
    {
        return $this->senderAdditional;
    }

    /**
     * @param string $senderAdditional
     * @return Configuration
     */
    public function setSenderAdditional(string $senderAdditional): Configuration
    {
        $this->senderAdditional = $senderAdditional;

        return $this;
    }

    /**
     * @return string
     */
    public function getSenderCity()
    {
        return $this->senderCity;
    }

    /**
     * @param string $senderCity
     * @return Configuration
     */
    public function setSenderCity(string $senderCity): Configuration
    {
        $this->senderCity = $senderCity;

        return $this;
    }

    /**
     * @return string
     */
    public function getSenderCountry()
    {
        return $this->senderCountry;
    }

    /**
     * @param string $senderCountry
     * @return Configuration
     */
    public function setSenderCountry(string $senderCountry): Configuration
    {
        $this->senderCountry = $senderCountry;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Configuration
     */
    public function setMessage(string $message): Configuration
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function getBillingInfo()
    {
        return $this->billingInfo;
    }

    /**
     * @param string $billingInfo
     * @return Configuration
     */
    public function setBillingInfo(string $billingInfo): Configuration
    {
        $this->billingInfo = $billingInfo;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getAlternativeSchemes()
    {
        return $this->alternativeSchemes;
    }

    /**
     * @return string
     */
    public function getAlternativeSchemesHtml()
    {
        return join('<br>', array_map(function ($schema) {
            $result = [];
            preg_match('/(.+):(.+)/', $schema, $result);
            if (count($result) == 3) {
                return sprintf('<strong>%s:</strong> %s', $result[1], $result[2]);
            }
            return $schema;
        }, $this->getAlternativeSchemes()));
    }

    /**
     * @param string[] $alternativeSchemes
     * @return Configuration
     */
    public function setAlternativeSchemes(array $alternativeSchemes): Configuration
    {
        $this->alternativeSchemes = $alternativeSchemes;

        return $this;
    }

    /**
     * @return string
     */
    public function getRawReferenceNumber()
    {
        return $this->referenceNumber;
    }

    /**
     * @return string
     */
    public function getReferenceNumber()
    {
        if ($this->getType() == self::TYPE_QR) {
            if ($this->getRef() == self::REF_QRR) {
                return $this->getCustomerIdentificationNumber().$this->getRawReferenceNumber();
            } elseif ($this->getRef() == self::REF_SCOR) {
                return $this->getRawReferenceNumber();
            }
        } else {
            return str_pad($this->getRawReferenceNumber(), 26, '0', STR_PAD_LEFT) .
                self::modulo10($this->getRawReferenceNumber())
                ;
        }
    }

    /**
     * @param string $referenceNumber
     * @return Configuration
     */
    public function setReferenceNumber(string $referenceNumber): Configuration
    {
        $this->referenceNumber = $referenceNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @param string $ref
     * @return Configuration
     */
    public function setRef(string $ref): Configuration
    {
        $this->ref = $ref;

        return $this;
    }

    /**
     * @return int
     */
    public function getCustomerIdentificationNumber()
    {
        return $this->customerIdentificationNumber;
    }

    /**
     * @param int $customerIdentificationNumber
     * @return Configuration
     */
    public function setCustomerIdentificationNumber(int $customerIdentificationNumber): Configuration
    {
        $this->customerIdentificationNumber = $customerIdentificationNumber;

        return $this;
    }

    /**
     * Gibt eine formatierte Referenznummer zurück
     */
    public function getNiceReferenceNumber()
    {
        $result = preg_split(
            '/(\d{2})(\d{5})(\d{5})(\d{5})(\d{5})(\d{5})/',
            $this->getReferenceNumber(),
            -1,
            PREG_SPLIT_DELIM_CAPTURE
        );

        return trim(implode(' ', $result));
    }

    /**
     * @return boolean
     */
    public function showEsrBackground()
    {
        return $this->esrBackground;
    }

    /**
     * @param boolean $esrBackground
     * @return Configuration
     */
    public function setEsrBackground(bool $esrBackground):Configuration
    {
        $this->esrBackground = $esrBackground;

        return $this;
    }

    /**
     * @see https://www.postfinance.ch/content/dam/pf/de/doc/consult/manual/dlserv/inpayslip_isr_man_de.pdf
     * @return string
     */
    public function getCode()
    {
        // Teilnehmernummer
        $account = explode('-', $this->getReceiverAccount());
        $account[1] = str_pad($account[1], 6, '0', STR_PAD_LEFT);
        $account = implode('', $account);

        return sprintf(
            '01' .          // ESR (mit vorgedrucktem Betrag)
            '%s' .          // Betrag
            '%s' .          // Prüfziffer
            '>'  .          // Hilfszeichen
            '%s' .          // Referenznummer mit Prüfziffer
            '+ ' .          // Hilfszeichen
            '%s' .          // Teilnehmernummer
            '>'             // Hilfszeichen
            ,
            str_pad($this->getAmount(), 10, '0', STR_PAD_LEFT),
            self::modulo10(sprintf(
                '01%s',
                str_pad($this->getAmount(), 10, '0', STR_PAD_LEFT)
            )),
            str_pad($this->getReferenceNumber(), 27, '0', STR_PAD_LEFT),
            $account,
            self::modulo10($account)
        );
    }

    private static function modulo10($number)
    {
        $digts = array(0,9,4,6,8,2,7,1,3,5);
        $next = 0;
        $nr = strlen($number);

        for ($i = 0; $i < $nr; $i++)
        {
            $next = $digts[($next + substr($number, $i, 1)) % 10];
        }

        return ((10 - $next) % 10);
    }
    /**
     * @return string|ConstraintViolationListInterface
     */
    public function getQrCode()
    {
        $qrBill = QrBill::create();
        $qrBill->setCreditorInformation(CreditorInformation::create($this->getReceiverAccountIBAN()));
        $qrBill->setCreditor(CombinedAddress::create(
            $this->getReceiver(),
            $this->getReceiverAddress().' '.$this->getReceiverAdditional(),
            $this->getReceiverCity(),
            $this->getReceiverCountry())
        );
        $qrBill->setPaymentAmountInformation(PaymentAmountInformation::create(
            $this->getCurrency(), $this->getAmount() / 100
        ));
        $qrBill->setUltimateDebtor(CombinedAddress::create(
            $this->getSender(),
            $this->getSenderAddress().' '.$this->getSenderAdditional(),
            $this->getSenderCity(),
            $this->getSenderCountry()
        ));
        if ($this->getRef() == self::REF_QRR) {
            $qrBill->setPaymentReference(PaymentReference::create(
                PaymentReference::TYPE_QR,
                QrPaymentReferenceGenerator::generate(
                    $this->getCustomerIdentificationNumber(), $this->getRawReferenceNumber()
                ))
            );
        } elseif ($this->getRef() == self::REF_SCOR) {
            $qrBill->setPaymentReference(PaymentReference::create(
                PaymentReference::TYPE_SCOR,
                $this->getReferenceNumber()
            ));
        }

        if ($this->getMessage() || $this->getBillingInfo()) {
            $qrBill->setAdditionalInformation(AdditionalInformation::create(
                $this->getMessage(), $this->getBillingInfo()
            ));
        }
        $qrBill->setAlternativeSchemes(array_map(function ($schema) {
            return AlternativeScheme::create($schema);
        }, $this->getAlternativeSchemes()));
        if ($qrBill->isValid()) {
            return base64_encode($qrBill->getQrCode()->writeString());
        } else {
            return $qrBill->getViolations();
        }
    }
}
