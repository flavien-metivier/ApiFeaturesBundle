<?php

namespace QualityCode\ApiFeaturesBundle\Tests\Unit\Entity;

use QualityCode\ApiFeaturesBundle\Tests\App\Entity\Fake;

class TimestamptableEntityTest extends \PHPUnit_Framework_TestCase
{
    private $entity = null;

    protected function setUp()
    {
        $this->entity = new Fake();
    }

    protected function tearDown()
    {
        $this->entity = null;
    }

    public function testEntityWithTimestamptableFeaturesTraitHasMethods()
    {
        $this->assertTrue(method_exists($this->entity, 'getCreatedAt'));
        $this->assertTrue(method_exists($this->entity, 'getUpdatedAt'));
        $this->assertTrue(method_exists($this->entity, 'getDeletedAt'));
        $this->assertTrue(method_exists($this->entity, 'setDeletedAt'));
    }
}
