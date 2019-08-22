<?php
namespace whatwedo\EsrBundle\Tests;


use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;
use whatwedo\EsrBundle\Configuration\Configuration;
use whatwedo\EsrBundle\Manager\EsrManager;

class FunctionalTest extends TestCase
{
    /** @var TestKernel */
    private $kernel;
    /** @var Filesystem */
    private $filesystem;
    public function setUp()
    {
        $this->kernel = new TestKernel(uniqid(), false);
        $this->filesystem = new Filesystem();
        $this->filesystem->mkdir($this->kernel->getCacheDir());
    }
    public function tearDown()
    {
        $this->filesystem->remove($this->kernel->getCacheDir());
    }
    public function testServiceIsAvailableOutOfTheBox()
    {
        $this->kernel->setConfigurationFilename(__DIR__ . '/fixtures/config/out_of_the_box.yml');
        $this->kernel->boot();
        $container = $this->kernel->getContainer();
        $this->assertTrue($container->has('whatwedo_esr.manager'), 'The ESR service is available.');
        $esrManager = $container->get('whatwedo_esr.manager');

        $this->assertInstanceof('whatwedo\EsrBundle\Manager\EsrManager', $esrManager);
    }


    public function testEsrA4Creation()
    {
        $this->kernel->setConfigurationFilename(__DIR__ . '/fixtures/config/out_of_the_box.yml');
        $this->kernel->boot();
        $container = $this->kernel->getContainer();

        $confguration = $this->getTestConfig();

        /** @var EsrManager $esrManager */
        $esrManager = $container->get('whatwedo_esr.manager');

        $esrManager->writePdfOutput(__DIR__ . '/testOutput.pdf', $confguration);
        $esrManager->writeHtmlOutput(__DIR__ . '/testOutput.html', $confguration);
        $this->assertFileExists(__DIR__ . '/testOutput.pdf');
        $this->assertFileExists(__DIR__ . '/testOutput.html');
        $this->assertFileEquals(__DIR__ . '/fixtures/outputs/outputEsr.html', __DIR__ . '/testOutput.html');
        unlink(__DIR__ . '/testOutput.pdf');
        unlink(__DIR__ . '/testOutput.html');
    }

    public function testEsrA5Creation()
    {
        $this->kernel->setConfigurationFilename(__DIR__ . '/fixtures/config/out_of_the_box.yml');
        $this->kernel->boot();
        $container = $this->kernel->getContainer();

        $confguration = $this->getTestConfig();
        $confguration->setFormat(Configuration::FORMAT_A5);
        $confguration->setType(Configuration::TYPE_ESR_BORDERED);

        /** @var EsrManager $esrManager */
        $esrManager = $container->get('whatwedo_esr.manager');

        $esrManager->writePdfOutput(__DIR__ . '/testOutput.pdf', $confguration);
        $esrManager->writeHtmlOutput(__DIR__ . '/testOutput.html', $confguration);
        $this->assertFileExists(__DIR__ . '/testOutput.pdf');
        $this->assertFileEquals(__DIR__ . '/fixtures/outputs/outputEsrBoxed.html', __DIR__ . '/testOutput.html');
        unlink(__DIR__ . '/testOutput.pdf');
        unlink(__DIR__ . '/testOutput.html');

    }

    public function testBEsrA5Creation()
    {
        $this->kernel->setConfigurationFilename(__DIR__ . '/fixtures/config/out_of_the_box.yml');
        $this->kernel->boot();
        $container = $this->kernel->getContainer();

        $confguration = $this->getTestConfig();
        $confguration->setFormat(Configuration::FORMAT_A5);
        $confguration->setType(Configuration::TYPE_BESR_BORDERED);

        /** @var EsrManager $esrManager */
        $esrManager = $container->get('whatwedo_esr.manager');

        $esrManager->writePdfOutput(__DIR__ . '/testOutput.pdf', $confguration);
        $esrManager->writeHtmlOutput(__DIR__ . '/testOutput.html', $confguration);
        $this->assertFileExists(__DIR__ . '/testOutput.pdf');
        $this->assertFileEquals(__DIR__ . '/fixtures/outputs/outputBesr.html', __DIR__ . '/testOutput.html');
        unlink(__DIR__ . '/testOutput.pdf');
        unlink(__DIR__ . '/testOutput.html');
    }

    public function testEsrESRCreation()
    {
        $this->kernel->setConfigurationFilename(__DIR__ . '/fixtures/config/out_of_the_box.yml');
        $this->kernel->boot();
        $container = $this->kernel->getContainer();

        $confguration = $this->getTestConfig();
        $confguration->setFormat(Configuration::FORMAT_ESR);
        $confguration->setType(Configuration::TYPE_BESR_BOXED);

        /** @var EsrManager $esrManager */
        $esrManager = $container->get('whatwedo_esr.manager');

        $esrManager->writePdfOutput(__DIR__ . '/testOutput.pdf', $confguration);
        $esrManager->writeHtmlOutput(__DIR__ . '/testOutput.html', $confguration);
        $this->assertFileExists(__DIR__ . '/testOutput.pdf');
        $this->assertFileEquals(__DIR__ . '/fixtures/outputs/outputBesrBoxed.html', __DIR__ . '/testOutput.html');
        unlink(__DIR__ . '/testOutput.pdf');
        unlink(__DIR__ . '/testOutput.html');
    }

    /**
     * @return Configuration
     */
    private function getTestConfig(): Configuration
    {
        $confguration = new Configuration();

        $confguration->setAmount(1234567890);
        $confguration->setBank('Bank');
        $confguration->setBankCity('BankCity');
        $confguration->setEsrBackground(true);
        $confguration->setReceiver('Reciever');
        $confguration->setReceiverAccount('30-12346');
        $confguration->setReceiverAdditional('revAdditional');
        $confguration->setReceiverAddress('revAddress');
        $confguration->setReceiverCity('1234 revCity');
        $confguration->setReferenceNumber('12345678901234567890123456');
        $confguration->setSender('Sender');
        $confguration->setSenderAddress('senderAddress');
        $confguration->setSenderAdditional('reviceverAdditional');
        $confguration->setSenderCity('9876 senderCity');
        return $confguration;
    }

}
