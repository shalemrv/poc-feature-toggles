<?php

namespace App\FeatureTogglesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FeatureFlag
 *
 * @ORM\Table(name="feature_flags")
 * @ORM\Entity(repositoryClass="App\FeatureTogglesBundle\Repository\FeatureFlagRepository")
 */
class FeatureFlag
{
    const ID                = 'id';
    const NAME              = 'name';
    const ACTIVE            = 'active';
    const PERCENTAGE        = 'percentage';

    //  EVERY FLAG ADDED TO DATABASE MUST BE ADDED HERE FOR DEVS TO ACCESS WITH AUTOCOMPLETE
    const INVOICE_GENERATION_MICROSERVICE   = 'INVOICE_GENERATION_MICROSERVICE';
    const TASK_MANAGEMENT_MICROSERVICE      = 'TASK_MANAGEMENT_MICROSERVICE';

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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var int
     *
     * @ORM\Column(name="percentage", type="smallint", nullable=true)
     */
    private $percentage;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return FeatureFlag
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return FeatureFlag
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set percentage
     *
     * @param integer $percentage
     *
     * @return FeatureFlag
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;

        return $this;
    }

    /**
     * Get percentage
     *
     * @return int
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * Get description
     *
     * @return array
     */
    public function toArray()
    {
        return [
            self::ID            => $this->id,
            self::NAME          => $this->name,
            self::ACTIVE        => $this->active,
            self::PERCENTAGE    => $this->percentage
        ];
    }
}

