<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Newspost
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Newspost
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titel", type="string", length=255)
     */
    private $titel;

    /**
     * @var string
     *
     * @ORM\Column(name="inhoud", type="text")
     */
    private $inhoud;

    /**
     * @var integer
     *
     * @ORM\Column(name="auteurid", type="integer")
     */
    private $auteurid;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datum", type="datetime")
     */
    private $datum;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titel
     *
     * @param string $titel
     * @return Newspost
     */
    public function setTitel($titel)
    {
        $this->titel = $titel;

        return $this;
    }

    /**
     * Get titel
     *
     * @return string 
     */
    public function getTitel()
    {
        return $this->titel;
    }

    /**
     * Set inhoud
     *
     * @param string $inhoud
     * @return Newspost
     */
    public function setInhoud($inhoud)
    {
        $this->inhoud = $inhoud;

        return $this;
    }

    /**
     * Get inhoud
     *
     * @return string 
     */
    public function getInhoud()
    {
        return $this->inhoud;
    }

    /**
     * Set auteurid
     *
     * @param integer $auteurid
     * @return Newspost
     */
    public function setAuteurid($auteurid)
    {
        $this->auteurid = $auteurid;

        return $this;
    }

    /**
     * Get auteurid
     *
     * @return integer 
     */
    public function getAuteurid()
    {
        return $this->auteurid;
    }

    /**
     * Set datum
     *
     * @param \DateTime $datum
     * @return Newspost
     */
    public function setDatum($datum)
    {
        $this->datum = $datum;

        return $this;
    }

    /**
     * Get datum
     *
     * @return \DateTime 
     */
    public function getDatum()
    {
        return $this->datum;
    }
}
