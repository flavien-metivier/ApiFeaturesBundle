<?php

namespace QualityCode\ApiFeaturesBundle\Tests\Unit\Controller;

use QualityCode\ApiFeaturesBundle\Tests\App\Controller\BasicFeaturesController;

class BasicFeaturesControllerTest extends \PHPUnit_Framework_TestCase
{
    private $controller = null;

    protected function setUp()
    {
        $this->controller = new BasicFeaturesController();
    }

    protected function tearDown()
    {
        $this->controller = null;
    }

    public function testControllerWithControllerBasicFeaturesTraitHasMethods()
    {
        $this->assertTrue(method_exists($this->controller, 'getCollection'));
        $this->assertTrue(method_exists($this->controller, 'getCollectionPaginated'));
        $this->assertTrue(method_exists($this->controller, 'getAnElement'));
        $this->assertTrue(method_exists($this->controller, 'createAnElement'));
        $this->assertTrue(method_exists($this->controller, 'removeAnElement'));
        $this->assertTrue(method_exists($this->controller, 'updateAnElement'));
        $this->assertTrue(method_exists($this->controller, 'checkFormAndPersist'));
    }
}
