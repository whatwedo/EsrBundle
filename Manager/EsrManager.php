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
namespace whatwedo\EsrBundle\Manager;

use Knp\Bundle\SnappyBundle\Snappy\LoggableGenerator;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;
use whatwedo\EsrBundle\Configuration\Configuration;

/**
 * @author Ueli Banholzer <ueli@whatwedo.ch>
 */
class EsrManager
{
    /**
     * @var Twig_Environment
     */
    protected $templating;

    /**
     * @var LoggableGenerator
     */
    protected $knpSnappy;

    public function __construct(Twig_Environment $templating, LoggableGenerator $knpSnappy)
    {
        $this->templating = $templating;
        $this->knpSnappy = $knpSnappy;
    }

    public function getPdfOutput(Configuration $configuration)
    {
        $html = $this->getHtmlOutput($configuration);

        $generator = $this->knpSnappy->getInternalGenerator();

        $generator->setOptions(array(
            'margin-bottom' => 0,
            'margin-left' => 0,
            'margin-right' => 0,
            'margin-top' => 0,
            'page-width' => 210,
            'page-height' => 297,
            'outline-depth' => 0,
        ));

        return $generator->getOutputFromHtml($html);
    }

    /**
     * @param Configuration $configuration
     * @return string HTML Output
     */
    protected function getHtmlOutput(Configuration $configuration)
    {
        $html = $this->templating->render('whatwedoEsrBundle::Pdf.html.twig', [
            'data' => $configuration,
        ]);

        return $html;
    }

    public function getPdfResponse(Configuration $configuration)
    {
        return new Response(
            $this->getPdfOutput($configuration),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="esr-' . $configuration->getRawReferenceNumber(). '.pdf"'
            )
        );
    }

    public function writePdfOutput($path, Configuration $configuration)
    {
        file_put_contents($path, $this->getPdfOutput($configuration));
    }

    public function writeHtmlOutput($path, Configuration $configuration)
    {
        file_put_contents($path, $this->getHtmlOutput($configuration));
    }
}
