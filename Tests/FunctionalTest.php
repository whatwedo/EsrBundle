<?php
namespace whatwedo\EsrBundle\Tests;


use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;
use whatwedo\EsrBundle\Configuration\Configuration;
use whatwedo\EsrBundle\Manager\EsrManager;

class FunctionalTest extends TestCase
{
    protected $container;
    /** @var TestKernel */
    private $kernel;
    /** @var Filesystem */
    private $filesystem;

    public function setUp(): void
    {
        $this->kernel = new TestKernel(uniqid(), false);
        $this->filesystem = new Filesystem();
        $this->filesystem->mkdir($this->kernel->getCacheDir());
    }
    public function tearDown(): void
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
        $confguration = $this->getTestConfig();

        $this->runConfigTest($confguration);
    }

    public function testEsrA5Creation()
    {
        $confguration = $this->getTestConfig();

        $confguration->setFormat(Configuration::FORMAT_A5);
        $confguration->setType(Configuration::TYPE_ESR_BORDERED);

        $this->runConfigTest($confguration);
    }

    public function testBEsrA5Creation()
    {
        $confguration = $this->getTestConfig();

        $confguration->setFormat(Configuration::FORMAT_A5);
        $confguration->setType(Configuration::TYPE_BESR_BORDERED);

        $this->runConfigTest($confguration);
    }

    public function testEsrESRCreation()
    {
        $confguration = $this->getTestConfig();

        $confguration->setFormat(Configuration::FORMAT_ESR);
        $confguration->setType(Configuration::TYPE_BESR_BOXED);

        $this->runConfigTest($confguration);
    }

    public function testEsrQrCreation()
    {
        $configuration = $this->getTestConfig();
        $configuration->setCustomerIdentificationNumber(210000);
        $configuration->setReferenceNumber('313947143000901');
        $configuration->setFormat(Configuration::FORMAT_A5);
        $configuration->setType(Configuration::TYPE_QR);

        $this->runConfigTest($configuration);
    }

    public function testWithNullConfiguration()
    {
        $configuration = $this->getTestConfig();
        $configuration->setCustomerIdentificationNumber(null);
        $configuration->setReferenceNumber('313947143000901');
        $configuration->setFormat(Configuration::FORMAT_A5);
        $configuration->setType(Configuration::TYPE_QR);

        $this->runConfigTest($configuration);
    }

    private function runConfigTest(Configuration $configuration)
    {
        $esrManager = $this->getEsrManager();
        $esrManager->writePdfOutput(__DIR__ . '/testOutput.pdf', $configuration);
        $esrManager->writeHtmlOutput(__DIR__ . '/testOutput.html', $configuration);
        $this->assertFileExists(__DIR__ . '/testOutput.pdf');
        $this->assertFileExists(__DIR__ . '/testOutput.html');
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
        $confguration->setReceiverAccountIBAN('CH4431999123000889012');
        $confguration->setReceiverAdditional('revAdditional');
        $confguration->setReceiverAddress('revAddress');
        $confguration->setReceiverCity('1234 revCity');
        $confguration->setCustomerIdentificationNumber('123456');
        $confguration->setReferenceNumber('78901234567890123456');
        $confguration->setSender('Sender');
        $confguration->setSenderAddress('senderAddress');
        $confguration->setSenderAdditional('reviceverAdditional');
        $confguration->setSenderCity('9876 senderCity');
        $confguration->setAlternativeSchemes([
            'Name AV1: UV;UltraPay005;12345',
            'Name AV2: XY;XYService;54321',
        ]);
        return $confguration;
    }

    /**
     * @return EsrManager
     */
    private function getEsrManager(): EsrManager
    {
        if ($this->container == null) {
            $this->kernel->setConfigurationFilename(__DIR__ . '/fixtures/config/out_of_the_box.yml');
            $this->kernel->boot();
            $this->container = $this->kernel->getContainer();
        }

        /** @var EsrManager $esrManager */
        $esrManager = $this->container->get('whatwedo_esr.manager');
        return $esrManager;
    }

}
