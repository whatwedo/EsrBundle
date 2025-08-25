<?php


namespace whatwedo\EsrBundle\Tests;

use Knp\Bundle\SnappyBundle\KnpSnappyBundle;
use Symfony\Bundle\DebugBundle\DebugBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;


class TestKernel extends Kernel
{
    private $configurationFilename;
    /**
     * Defines the configuration filename.
     *
     * @param string $filename
     */
    public function setConfigurationFilename($filename): void
    {
        $this->configurationFilename = $filename;
    }
    /**
     * {@inheritdoc}
     */
    public function registerBundles(): array
    {
        return [
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \whatwedo\EsrBundle\whatwedoEsrBundle(),
            new TwigBundle(),
            new KnpSnappyBundle(),


        ];
    }
    /**
     * {@inheritdoc}
     */
    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load($this->configurationFilename);
    }
}
