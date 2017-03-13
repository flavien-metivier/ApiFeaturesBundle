<?php

namespace QualityCode\ApiFeaturesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use Hateoas\Configuration\Route;
use Hateoas\Representation\Factory\PagerfantaFactory;
use Symfony\Component\Form\Form;

/**
 * Description of controllerBasicFeatures.
 *
 * @author fmetivier
 */
trait ControllerBasicFeaturesTrait
{
    /**
     * Gets a container service by its id.
     *
     * @param string $id The service id
     *
     * @return object The service
     */
    abstract protected function get($id);

    /**
     * Creates and returns a Form instance from the type of the form.
     *
     * @param string $type    The fully qualified class name of the form type
     * @param mixed  $data    The initial data for the form
     * @param array  $options Options for the form
     *
     * @return Form
     */
    abstract protected function createForm($type, $data = null, array $options = array());

    /**
     * @param string $repositoryName
     *
     * @return array
     */
    protected function getCollection($repositoryName)
    {
        $collection = $this->get('doctrine.orm.entity_manager')
                ->getRepository($repositoryName)
                ->findAll();

        return $collection;
    }

    /**
     * @param Request $request
     * @param string  $repositoryName
     *
     * @return array
     */
    protected function getCollectionPaginated(Request $request, $repositoryName)
    {
        $limit = $request->query->getInt('limit', 10);
        $page = $request->query->getInt('page', 1);
        $sorting = $request->query->get('sorting', array());
        $searching = $request->query->get('searching', array());

        $collectionPager = $this->get('doctrine.orm.entity_manager')
                ->getRepository($repositoryName)
                ->findAllPaginated($limit, $page, $sorting, $searching);

        $pagerFactory = new PagerfantaFactory();

        return $pagerFactory->createRepresentation(
            $collectionPager,
            new Route($request->get('_route'), array(
                'limit' => $limit,
                'page' => $page,
                'sorting' => $sorting,
                'searching' => $searching,
            ))
        );
    }

    /**
     * @param Request $request
     * @param string  $repositoryName
     *
     * @return mixed|\FOS\RestBundle\View\View
     */
    protected function getAnElement(Request $request, $repositoryName)
    {
        $anElement = $this->get('doctrine.orm.entity_manager')
                ->getRepository($repositoryName)
                ->find($request->get('id'));

        if (empty($anElement)) {
            return View::create(['message' => 'Element not found'], Response::HTTP_NOT_FOUND);
        }

        return $anElement;
    }

    /**
     * @param Request $request
     * @param mixed   $element
     * @param string  $formClassName
     *
     * @return mixed
     */
    protected function createAnElement(Request $request, $element, $formClassName)
    {
        $form = $this->createForm($formClassName, $element, array('csrf_protection' => false, ));

        $form->submit($request->request->all(), false);

        return $this->checkFormAndPersist($form, $element);
    }

    /**
     * @param Request $request
     * @param string  $repositoryName
     */
    protected function removeAnElement(Request $request, $repositoryName)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $element = $em->getRepository($repositoryName)
                ->find($request->get('id'));

        if ($element) {
            $em->remove($element);
            $em->flush();
        }
    }

    /**
     * @param Request $request
     * @param bool $clearMissing
     * @param $repositoryName
     * @param $formClassName
     *
     * @return mixed|Form|\FOS\RestBundle\View\View
     */
    protected function updateAnElement(Request $request, $clearMissing, $repositoryName, $formClassName)
    {
        $element = $this->get('doctrine.orm.entity_manager')
                ->getRepository($repositoryName)
                ->find($request->get('id'));

        if (empty($element)) {
            return View::create(['message' => 'Element not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm($formClassName, $element);

        $form->submit($request->request->all(), $clearMissing);

        return $this->checkFormAndPersist($form, $element);
    }

    /**
     * @param Form  $form
     * @param mixed $element
     *
     * @return mixed|Form
     */
    private function checkFormAndPersist(Form $form, $element)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($element);
            $em->flush();

            return $element;
        }

        return $form;
    }
}
