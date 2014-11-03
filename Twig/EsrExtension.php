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
 
namespace whatwedo\EsrBundle\Twig;

use Symfony\Component\HttpFoundation\File\File;
use whatwedo\EsrBundle\Configuration\Configuration;

/**
 * @author Ueli Banholzer <ueli@whatwedo.ch>
 */
class EsrExtension extends \Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'esrBase64Background' => new \Twig_Function_Method($this, 'getBackground'),
        );
    }

    public function getBackground($type = Configuration::TYPE_ESR_BOXED)
    {
        $file = null;

        switch ($type) {
            case Configuration::TYPE_ESR_BORDERED:
                $file = new File(__DIR__ . '/../Resources/public/images/esr_bordered.jpg');
                break;
            case Configuration::TYPE_BESR_BOXED:
                $file = new File(__DIR__ . '/../Resources/public/images/besr_boxed.jpg');
                break;
            case Configuration::TYPE_BESR_BORDERED:
                $file = new File(__DIR__ . '/../Resources/public/images/besr_bordered.jpg');
                break;
            default:
                $file = new File(__DIR__ . '/../Resources/public/images/esr_boxed.jpg');
                break;
        }

        return sprintf(
            'data:image/%s;base64,%s',
            $file->guessExtension(),
            base64_encode(file_get_contents($file->getRealPath()))
        );
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'whatwedo_esr_extension';
    }
}