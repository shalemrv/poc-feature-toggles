<?php

namespace App\ProjectsBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Project
 *
 * @ORM\Table(name="projects")
 * @ORM\Entity(repositoryClass="App\ProjectsBundle\Repository\ProjectRepository")
 */
class Project
{
    const ID            = 'id';
    const NAME          = 'name';
    const START         = 'start';
    const END           = 'end';
    const DESCRIPTION   = 'description';
    const INVOICE       = 'invoice';

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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start", type="datetime")
     */
    private $start;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end", type="datetime")
     */
    private $end;


    //--------------------^--------------------//
    //--------------------^--------------------//


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
     * @return Project
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
     * Set description
     *
     * @param string $description
     *
     * @return Project
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set start
     *
     * @param string $start
     *
     * @return Project
     */
    public function setStartTime($start = 'now')
    {
        $this->start = new DateTime($start);

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param string $end
     *
     * @return Project
     */
    public function setEndTime($end = 'now')
    {
        $this->end = new DateTime($end);

        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime
     */
    public function getEndTime()
    {
        return $this->end;
    }

    /**
     * Get Plain date time string
     *
     * @param \DateTime $date
     *
     * @return string
     */
    private function formateDate(\DateTime $date) {
        return $date->format('Y-m-d H:i:s');
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
            self::DESCRIPTION   => $this->description,
            self::START         => $this->formateDate($this->start),
            self::END           => $this->formateDate($this->end)
        ];
    }
}