<?php

namespace QualityCode\ApiFeaturesBundle\Tests\Functionnal\Controller;

/**
 * @author flavien-metivier
 */
class FakeControllerTest extends WebTestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->fieldsList = [
            'id',
            'field1',
            'field2',
            'created_at',
            'updated_at',
            'deleted_at',
        ];
        $this->itemValues = [
            'field1' => 'fakevalue',
            'field2' => 'fakeValue',
        ];

        $this->itemsBadValues = [
            'field1' => null,
            'field2' => 'fakeValue',
        ];
        $this->route = 'fake';
    }

    public function testGetAllFake()
    {
        $this->checkGetAll('/'.$this->route, 3);
    }

    public function testGetAFake()
    {
        $this->checkGetAnElement('/'.$this->route.'/1');
    }

    public function testGetAUnexistingFake()
    {
        $this->checkGetAUnexistingElement('/'.$this->route.'/555');
    }

    public function testDeleteAFake()
    {
        $this->checkDeleteAnElement('/'.$this->route.'/2');
    }

    public function testDeleteAUnexistingFake()
    {
        $this->checkDeleteAnElement('/'.$this->route.'/555');
    }

    public function testAddAFake()
    {
        $this->checkAddOrUpdateOrPatchAnElement('/'.$this->route.'');
    }

    public function testAddAFakeWithBadField()
    {
        $this->checkAddOrUpdateOrPatchAnElement('/'.$this->route.'', true);
    }

    public function testUpdateAFake()
    {
        $this->checkAddOrUpdateOrPatchAnElement('/'.$this->route.'/1', false, 'PUT');
    }

    public function testUpdateAUnexistingFake()
    {
        $this->checkUpdateOrPatchAUnexistingElement('/'.$this->route.'/555', 'PUT');
    }

    public function testUpdateAFakeWithBadField()
    {
        $this->checkAddOrUpdateOrPatchAnElement('/'.$this->route.'/1', true, 'PUT');
    }

    public function testPatchAFake()
    {
        $this->checkAddOrUpdateOrPatchAnElement('/'.$this->route.'/1', false, 'PATCH');
    }

    public function testPatchAUnexistingFake()
    {
        $this->checkUpdateOrPatchAUnexistingElement('/'.$this->route.'/555', 'PATCH');
    }

    public function testPatchAFakeWithBadField()
    {
        $this->checkAddOrUpdateOrPatchAnElement('/'.$this->route.'/1', true, 'PATCH');
    }
}
