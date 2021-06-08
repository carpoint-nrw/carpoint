<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class DatabaseDump
 *
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\DatabaseDumpRepository")
 *
 * @package AdminBundle\Entity
 */
class DatabaseDump
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $fileName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getFileName():? string
    {
        return $this->fileName;
    }

    /**
     * @param string|null $fileName
     *
     * @return static
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDate():? \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime|null $date
     *
     * @return static
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }
}