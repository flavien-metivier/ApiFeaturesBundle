<?php

namespace QualityCode\ApiFeaturesBundle\Tests\App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Hateoas\Configuration\Annotation as Hateoas;
use QualityCode\ApiFeaturesBundle\Entity\TimestampableFeaturesTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Fake.
 *
 * @Gedmo\Loggable
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\Table(name="fake")
 * @ORM\Entity(repositoryClass="QualityCode\ApiFeaturesBundle\Tests\App\Repository\FakeRepository")
 *  * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "get_fake",
 *          parameters = {
 *              "id" = "expr(object.getId())"
 *          }
 *      )
 * )
 * @Hateoas\Relation(
 *      "patch",
 *      href = @Hateoas\Route(
 *          "patch_fake",
 *          parameters = {
 *              "id" = "expr(object.getId())"
 *          }
 *      )
 * )
 * @Hateoas\Relation(
 *      "update",
 *      href = @Hateoas\Route(
 *          "update_fake",
 *          parameters = {
 *              "id" = "expr(object.getId())"
 *          }
 *      )
 * )
 * @Hateoas\Relation(
 *      "create",
 *      href = @Hateoas\Route(
 *          "post_fake"
 *      )
 * )
 * @Hateoas\Relation(
 *      "list",
 *      href = @Hateoas\Route(
 *          "get_fakes"
 *      )
 * )
 * @Hateoas\Relation(
 *      "remove",
 *      href = @Hateoas\Route(
 *          "remove_fake",
 *          parameters = {
 *              "id" = "expr(object.getId())"
 *          }
 *      )
 * )
 */
class Fake
{
    use TimestampableFeaturesTrait;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Gedmo\Versioned
     * @ORM\Column(name="field1", type="string", length=4, nullable=false)
     */
    private $field1;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Gedmo\Versioned
     * @ORM\Column(name="field2", type="string", length=45, nullable=false)
     */
    private $field2;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $field1
     *
     * @return Fake
     */
    public function setField1($field1)
    {
        $this->field1 = $field1;

        return $this;
    }

    /**
     * @return string
     */
    public function getField1()
    {
        return $this->field1;
    }

    /**
     * @param string $field2
     *
     * @return Fake
     */
    public function setField2($field2)
    {
        $this->field2 = $field2;

        return $this;
    }

    /**
     * @return string
     */
    public function getField2()
    {
        return $this->field2;
    }
}
