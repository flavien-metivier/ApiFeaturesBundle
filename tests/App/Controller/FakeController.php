<?php

namespace QualityCode\ApiFeaturesBundle\Tests\App\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use QualityCode\ApiFeaturesBundle\Controller\ControllerBasicFeaturesTrait;
use QualityCode\ApiFeaturesBundle\Tests\App\Entity\Fake;
use QualityCode\ApiFeaturesBundle\Tests\App\Form\FakeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of FakeController.
 *
 * @author flavien-metivier
 */
class FakeController extends Controller
{
    use ControllerBasicFeaturesTrait;

    /**
     * @ApiDoc(
     *      resource=true,
     *      description="Récupérer une liste d'fake",
     *      output="Hateoas\Representation\PaginatedRepresentation",
     * )
     *
     * @Rest\View()
     * @Rest\Get("/fake")
     */
    public function getFakesAction(Request $request)
    {
        return $this->getCollectionPaginated($request, 'Fake:Fake');
    }

    /**
     * @ApiDoc(
     *      resource=true,
     *      description="Récupérer une fake",
     *      output="QualityCode\ApiFeaturesBundle\Tests\App\Entity\Fake",
     * )
     *
     * @Rest\View()
     * @Rest\Get("/fake/{id}", requirements={"id" = "\d+"})
     */
    public function getFakeAction(Request $request)
    {
        return $this->getAnElement($request, 'Fake:Fake');
    }

    /**
     * @ApiDoc(
     *  description="Créer une nouvelle fake",
     *  input="QualityCode\ApiFeaturesBundle\Tests\App\Form\FakeType",
     *  output="QualityCode\ApiFeaturesBundle\Tests\App\Entity\Fake",
     *  statusCodes = {
     *        201 = "Création avec succès",
     *        400 = "Formulaire invalide"
     *   },
     *  responseMap={
     *         201 = {"class"=QualityCode\ApiFeaturesBundle\Tests\App\Entity\Fake::class},
     *         400 = {"class"=QualityCode\ApiFeaturesBundle\Tests\App\Form\FakeType::class, "fos_rest_form_errors"=true, "name" = ""}
     *    }
     * )
     *
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/fake")
     */
    public function postFakeAction(Request $request)
    {
        $fake = new Fake();

        return $this->createAnElement($request, $fake, FakeType::class);
    }

    /**
     * @ApiDoc(
     *      description="Supprimer une fake",
     * )
     *
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/fake/{id}", requirements={"id" = "\d+"})
     */
    public function removeFakeAction(Request $request)
    {
        $this->removeAnElement($request, 'Fake:Fake');
    }

    /**
     * @ApiDoc(
     *      description="Mettre à jour un  Fake",
     *      input="QualityCode\ApiFeaturesBundle\Tests\App\Form\FakeType",
     *      output="QualityCode\ApiFeaturesBundle\Tests\App\Entity\Fake"
     * )
     *
     * @Rest\View()
     * @Rest\Put("/fake/{id}", requirements={"id" = "\d+"})
     */
    public function updateFakeAction(Request $request)
    {
        return $this->updateAnElement($request, false, 'Fake:Fake', FakeType::class);
    }

    /**
     * @ApiDoc(
     *      description="Mettre à jour partiellement une fake",
     *      input="QualityCode\ApiFeaturesBundle\Tests\App\Form\FakeType",
     *      output="QualityCode\ApiFeaturesBundle\Tests\App\Entity\Fake"
     * )
     *
     * @Rest\View()
     * @Rest\Patch("/fake/{id}", requirements={"id" = "\d+"})
     */
    public function patchFakeAction(Request $request)
    {
        return $this->updateAnElement($request, true, 'Fake:Fake', FakeType::class);
    }
}
