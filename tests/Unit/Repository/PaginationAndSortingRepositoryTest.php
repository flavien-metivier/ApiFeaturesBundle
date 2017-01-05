<?php

namespace QualityCode\ApiFeaturesBundle\Tests\Unit\Entity;

use QualityCode\ApiFeaturesBundle\Tests\App\Repository\FakeRepository;

class PaginationAndSortingRepositoryTest extends \PHPUnit_Framework_TestCase
{
    private $repository = null;

    protected function setUp()
    {
        $em = $this->getMockBuilder(\Doctrine\ORM\EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $class = $this->getMockBuilder(\Doctrine\ORM\Mapping\ClassMetadata::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->repository = new FakeRepository($em, $class);
    }

    protected function tearDown()
    {
        $this->repository = null;
    }

    public function testEntityWithTimestamptableFeaturesTraitHasMethods()
    {
        $this->assertTrue(method_exists($this->repository, 'findAllPaginated'));
        $this->assertTrue(method_exists($this->repository, 'addOrderBy'));
        $this->assertTrue(method_exists($this->repository, 'addSearchBy'));
    }
}
