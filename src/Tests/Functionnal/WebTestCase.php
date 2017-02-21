<?php

namespace QualityCode\ApiFeaturesBundle\Tests\Functionnal;

use Faker\Factory as FakerFactory;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;

class WebTestCase extends BaseWebTestCase
{
    protected $faker;

    /**
     * @var array
     */
    protected $fieldsList;

    /**
     * @var array
     */
    protected $fieldsDetails = [];

    /**
     * @var array
     */
    protected $links = [
        'self', 'create', 'update', 'patch', 'remove', 'list',
    ];

    /**
     * @var array
     */
    protected $itemValues;

    /**
     * @var array
     */
    protected $itemsBadValues;

    /**
     * @var string
     */
    protected $route;

    protected function setUp()
    {
        $this->faker = FakerFactory::create();
    }

    /**
     * @param string $route
     * @param int    $expectedItems
     */
    protected function checkGetAll(string $route, int $expectedItems)
    {
        $client = $this->getClient('GET', $route);
        $this->checkStatusCodeAndContentType($client, 200);

        $items = json_decode($client->getResponse()->getContent());

        $this->checkIfListHaveRightStructure($items);

        $this->checkItemList($items, $expectedItems);
    }

    /**
     * @param string $route
     */
    protected function checkGetAnElement(string $route)
    {
        $client = $this->getClient('GET', $route);
        $this->checkStatusCodeAndContentType($client, 200);
        $item = json_decode($client->getResponse()->getContent());

        $this->checkIfItemHasTheRightFieldsNumber((array) $item, true);
        $this->checkIfItemHasFields((array) $item);
        $this->checkIfItemHasLinks((array) $item);
    }

    /**
     * @param string $route
     */
    protected function checkGetAUnexistingElement(string $route)
    {
        $client = $this->getClient('GET', $route);
        $this->checkStatusCodeAndContentType($client, '404');
        $adresse = json_decode($client->getResponse()->getContent());

        $this->assertArrayHasKey('message', (array) $adresse);
        $this->assertSame('Element not found', $adresse->message);
    }

    /**
     * @param string $route
     * @param string $method
     */
    protected function checkUpdateOrPatchAUnexistingElement(string $route, string $method)
    {
        $client = static::createClient();
        $client->request(
                $method, $route, [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($this->itemValues)
        );

        $this->checkStatusCodeAndContentType($client, 404);
        $item = json_decode($client->getResponse()->getContent());
        $this->assertArrayHasKey('message', (array) $item);
        $this->assertSame('Element not found', $item->message);
    }

    /**
     * @param string $route
     * @param bool   $mustHaveErrors
     * @param string $method
     */
    protected function checkAddOrUpdateOrPatchAnElement(string $route, bool $mustHaveErrors = false, string $method = 'POST')
    {
        $values = $this->itemValues;
        $statusCode = $method === 'POST' ? 201 : 200;
        if ($mustHaveErrors) {
            $values = $this->itemsBadValues;
            $statusCode = 400;
        }

        $client = $client = static::createClient();
        $client->request(
                $method, $route, [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($values)
        );
        $this->checkStatusCodeAndContentType($client, $statusCode);
        $item = json_decode($client->getResponse()->getContent(), true);

        if (!$mustHaveErrors) {
            $this->checkIfItemHasTheRightFieldsNumber((array) $item, true);
            $this->checkIfItemHasFields((array) $item);
            $this->checkIfItemHasLinks((array) $item);
            foreach ($values as $key => $value) {
                $this->assertSame($value, $item[$key]);
            }
        } else {
            $this->assertSame(3, count((array) $item));
            $this->assertArrayHasKey('code', (array) $item);
            $this->assertArrayHasKey('message', (array) $item);
            $this->assertArrayHasKey('errors', (array) $item);
        }
    }

    /**
     * @param Client $client
     * @param int    $statusCode
     */
    protected function checkStatusCodeAndContentType(Client $client, int $statusCode)
    {
        $this->assertSame($statusCode, $client->getResponse()->getStatusCode());
        $this->assertTrue(
                $client->getResponse()->headers->contains(
                        'Content-Type', 'application/json'
                ), 'the "Content-Type" header is "application/json"'
        );
    }

    /**
     * @param string $route
     */
    protected function checkDeleteAnElement(string $route)
    {
        $client = static::createClient();

        $client->request('DELETE', $route);
        $this->assertSame(204, $client->getResponse()->getStatusCode());
    }

    /**
     * @param string $method
     * @param string $route
     *
     * @return Client
     */
    protected function getClient(string $method, string $route)
    {
        $client = static::createClient();

        $client->request($method, $route);

        return $client;
    }

    /**
     * @param array $item
     */
    protected function checkIfItemHasFields(array $item)
    {
        foreach ($this->fieldsList as $fieldName) {
            $this->assertArrayHasKey($fieldName, (array) $item);
        }
    }

    /**
     * @param array $item
     */
    protected function checkIfItemHasLinks(array $item)
    {
        $this->assertArrayHasKey('_links', (array) $item);
        foreach ($this->links as $fieldName) {
            $this->assertArrayHasKey($fieldName, (array) $item['_links']);
        }
    }

    /**
     * @param array $item
     */
    protected function checkIfItemHasTheRightFieldsNumber(array $item, $isDetails = false)
    {
        if ($isDetails) {
            $this->assertSame(count($this->fieldsList) + count($this->fieldsDetails) + 1, count((array) $item));
        } else {
            $this->assertSame(count($this->fieldsList) + 1, count((array) $item));
        }
    }

    /**
     * @param \stdClass $list
     */
    protected function checkIfListHaveRightStructure(\stdClass $list)
    {
        $this->assertSame(1, count($list));
        $this->assertObjectHasAttribute('page', $list);
        $this->assertObjectHasAttribute('pages', $list);
        $this->assertObjectHasAttribute('limit', $list);
        $this->assertObjectHasAttribute('total', $list);
        $this->assertObjectHasAttribute('_links', $list);
        $this->assertObjectHasAttribute('self', $list->_links);
        $this->assertObjectHasAttribute('first', $list->_links);
        $this->assertObjectHasAttribute('last', $list->_links);
        $this->assertObjectHasAttribute('_embedded', $list);
        $this->assertObjectHasAttribute('items', $list->_embedded);
    }

    /**
     * @param \stdClass $items
     * @param int       $expectedSize
     */
    protected function checkItemList(\stdClass $items, int $expectedSize)
    {
        $this->assertSame($expectedSize, count($items->_embedded->items));

        foreach ($items->_embedded->items as $adresse) {
            $this->checkIfItemHasTheRightFieldsNumber((array) $adresse);
            $this->checkIfItemHasFields((array) $adresse);
            $this->checkIfItemHasLinks((array) $adresse);
        }
    }
}
