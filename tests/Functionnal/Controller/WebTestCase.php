<?php

namespace QualityCode\ApiFeaturesBundle\Tests\Functionnal\Controller;

use QualityCode\ApiFeaturesBundle\Tests\Functionnal\WebTestCase as BaseWebTestCase;

/**
 * Description of WebTestCase.
 *
 * @author fmetivier
 */
class WebTestCase extends BaseWebTestCase
{
    protected static function getKernelClass()
    {
        return '\QualityCode\ApiFeaturesBundle\Tests\App\AppKernel';
    }
}
