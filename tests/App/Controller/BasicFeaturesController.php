<?php

namespace QualityCode\ApiFeaturesBundle\Tests\App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
//use Senalia\AppBundle\Entity\Adresse;
//use Senalia\AppBundle\Form\Type\AdresseType;
use QualityCode\ApiFeaturesBundle\Controller\ControllerBasicFeaturesTrait;

/**
 * Description of AdresseController.
 *
 * @author fmetivier
 */
class BasicFeaturesController extends Controller
{
    use ControllerBasicFeaturesTrait;

//    /**
//     * @ApiDoc(
//     *      resource=true,
//     *      description="Récupérer une liste d'adresse",
//     * )
//     *
//     * @Rest\View()
//     * @Rest\Get("/adresse")
//     */
//    public function getAdressesAction(Request $request)
//    {
//        return $this->getCollectionPaginated($request, 'AppBundle:Adresse');
//    }

//    /**
//     * @ApiDoc(
//     *      resource=true,
//     *      description="Récupérer une adresse",
//     *      output="AppBundle\Entity\Adresse",
//     * )
//     *
//     * @Rest\View()
//     * @Rest\Get("/adresse/{id}", requirements={"id" = "\d+"})
//     */
//    public function getAdresseAction(Request $request)
//    {
//        return $this->getAnElement($request, 'AppBundle:Adresse');
//    }

//    /**
//     * @ApiDoc(
//     *  description="Créer une nouvelle adresse",
//     *  input="AppBundle\Form\Type\AdresseType",
//     *  output="AppBundle\Entity\Adresse",
//     *  statusCodes = {
//     *        201 = "Création avec succès",
//     *        400 = "Formulaire invalide"
//     *   },
//     *  responseMap={
//     *         201 = {"class"=AppBundle\Entity\Adresse::class},
//     *         400 = {"class"=AppBundle\Form\Type\AdresseType::class, "fos_rest_form_errors"=true, "name" = ""}
//     *    }
//     * )
//     *
//     * @Rest\View(statusCode=Response::HTTP_CREATED)
//     * @Rest\Post("/adresse")
//     */
//    public function postAdresseAction(Request $request)
//    {
//        $adresse = new Adresse();

//        return $this->createAnElement($request, $adresse, AdresseType::class);
//    }

//    /**
//     * @ApiDoc(
//     *      description="Supprimer une adresse",
//     * )
//     *
//     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
//     * @Rest\Delete("/adresse/{id}", requirements={"id" = "\d+"})
//     */
//    public function removeAdresseAction(Request $request)
//    {
//        $this->removeAnElement($request, 'AppBundle:Adresse');
//    }

//    /**
//     * @ApiDoc(
//     *      description="Mettre à jour un  Adresse",
//     *      input="AppBundle\Form\Type\AdresseType",
//     *      output="AppBundle\Entity\Adresse"
//     * )
//     *
//     * @Rest\View()
//     * @Rest\Put("/adresse/{id}", requirements={"id" = "\d+"})
//     */
//    public function updateAdresseAction(Request $request)
//    {
//        return $this->updateAnElement($request, false, 'AppBundle:Adresse', AdresseType::class);
//    }

//    /**
//     * @ApiDoc(
//     *      description="Mettre à jour partiellement une adresse",
//     *      input="AppBundle\Form\Type\AdresseType",
//     *      output="AppBundle\Entity\Adresse"
//     * )
//     *
//     * @Rest\View()
//     * @Rest\Patch("/adresse/{id}", requirements={"id" = "\d+"})
//     */
//    public function patchAdresseAction(Request $request)
//    {
//        return $this->updateAnElement($request, true, 'AppBundle:Adresse', AdresseType::class);
//    }
}
