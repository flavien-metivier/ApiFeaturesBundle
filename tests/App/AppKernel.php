<?php

namespace QualityCode\ApiFeaturesBundle\Tests\App;

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;
use QualityCode\ApiFeaturesBundle\QualityCodeApiFeaturesBundle;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        return [
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new QualityCodeApiFeaturesBundle(),
            new \Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new \Hautelook\AliceBundle\HautelookAliceBundle(),

        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config.yml');
    }
}
