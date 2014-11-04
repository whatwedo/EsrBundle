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

 /**
 * @author Ueli Banholzer <ueli@whatwedo.ch>
 */
class Configuration
{
    const TYPE_ESR_BOXED     = 1;
    const TYPE_ESR_BORDERED  = 2;
    const TYPE_BESR_BOXED    = 4;
    const TYPE_BESR_BORDERED = 8;

    /**
     * @var int ESR-Typ
     */
    protected $type = self::TYPE_ESR_BOXED;

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
     * @var string Konto-Nummer (01-XXX-XX)
     */
    protected $receiverAccount = '';

    /**
     * @var int Betrag
     */
    protected $amount = 0;

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
     * @var string Referenznummer (inkl. Prüfziffer)
     */
    protected $referenceNumber = '';

    /**
     * @var bool Soll ESR-Hintergrund gedruckt werden?
     */
    protected $esrBackground = false;

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
    public function setType($type)
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
    public function setBank($bank)
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
    public function setBankCity($bankCity)
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
    public function setReceiver($receiver)
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
    public function setReceiverAddress($receiverAddress)
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
    public function setReceiverAdditional($receiverAdditional)
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
    public function setReceiverCity($receiverCity)
    {
        $this->receiverCity = $receiverCity;

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
    public function setReceiverAccount($receiverAccount)
    {
        $this->receiverAccount = $receiverAccount;

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
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

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
    public function setSender($sender)
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
    public function setSenderAddress($senderAddress)
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
    public function setSenderAdditional($senderAdditional)
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
    public function setSenderCity($senderCity)
    {
        $this->senderCity = $senderCity;

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
        return str_pad($this->getRawReferenceNumber(), 26, '0', STR_PAD_LEFT) .
            self::modulo10($this->getRawReferenceNumber())
            ;
    }

    /**
     * @param string $referenceNumber
     * @return Configuration
     */
    public function setReferenceNumber($referenceNumber)
    {
        $this->referenceNumber = $referenceNumber;

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
    public function setEsrBackground($esrBackground = true)
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

    static function modulo10($number)
    {
        $digts = array(0,9,4,6,8,2,7,1,3,5);
        $next = 0;

        for ($i = 0; $i < strlen($number); $i++)
        {
            $next = $digts[($next + substr($number, $i, 1)) % 10];
        }

        return ((10 - $next) % 10);
    }
}