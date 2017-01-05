<?php

namespace QualityCode\ApiFeaturesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use Symfony\Component\Workflow\Workflow;

/**
 * Add workflow features on a controller.
 *
 * @author flavien-metivier
 */
trait ControllerWorkflowFeaturesTrait
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
     * @param Request $request
     * @param string  $repositoryName
     * @param string  $workflowName
     *
     * @return mixed
     */
    protected function workflowStatutAvailable(Request $request, $repositoryName, $workflowName)
    {
        $element = $this->get('doctrine.orm.entity_manager')
                ->getRepository($repositoryName)
                ->find($request->get('id'));

        if (empty($element)) {
            return View::create(['message' => 'Element not found'], Response::HTTP_NOT_FOUND);
        }

        $workflow = $this->get('workflow.'.$workflowName);

        return $workflow->getEnabledTransitions($element);
    }

    /**
     * @param Request $request
     * @param string  $repositoryName
     * @param string  $workflowName
     *
     * @return mixed
     */
    protected function changeWorkflowStatut(Request $request, $repositoryName, $workflowName)
    {
        $element = $this->get('doctrine.orm.entity_manager')
                ->getRepository($repositoryName)
                ->find($request->get('id'));

        $newState = $request->get('state_name');
        $workflow = $this->get('workflow.'.$workflowName);

        $can = $this->checkIfElementCanChangeStatut($newState, $workflow, $element);
        if ($can !== false) {
            return $can;
        }

        $workflow->apply($element, $newState);
        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($element);
        $em->flush();

        return $element;
    }

    /**
     * @param string   $newState
     * @param Workflow $workflow
     * @param mixed    $element
     *
     * @return bool|\FOS\RestBundle\View\View
     */
    protected function checkIfElementCanChangeStatut(string $newState, Workflow $workflow, $element)
    {
        if (empty($element)) {
            return View::create(['message' => 'Element not found'], Response::HTTP_NOT_FOUND);
        }

        if (!$workflow->can($element, $newState)) {
            return View::create(['message' => 'Workflow state not available'], Response::HTTP_FORBIDDEN);
        }

        return true;
    }
}
