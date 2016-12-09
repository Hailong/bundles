<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Lead;

/**
 * Device
 *
 * @ORM\Table(name="devices")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DeviceRepository")
 */
class Device
{
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
     * @ORM\Column(name="fingerprint", type="string", length=255, unique=true)
     */
    private $fingerprint;

    /**
     * @var string
     *
     * @ORM\Column(name="platform", type="string", length=255)
     */
    private $platform;

    /**
     * @ORM\ManyToOne(targetEntity="Lead")
     * @ORM\JoinColumn(name="lead_id", referencedColumnName="id")
     */
    private $lead;


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
     * Set fingerprint
     *
     * @param string $fingerprint
     *
     * @return Device
     */
    public function setFingerprint($fingerprint)
    {
        $this->fingerprint = $fingerprint;

        return $this;
    }

    /**
     * Get fingerprint
     *
     * @return string
     */
    public function getFingerprint()
    {
        return $this->fingerprint;
    }

    /**
     * Set platform
     *
     * @param string $platform
     *
     * @return Device
     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;

        return $this;
    }

    /**
     * Get platform
     *
     * @return string
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * Set lead
     *
     * @param string $lead
     *
     * @return Device
     */
    public function setLead($lead)
    {
        $this->lead = $lead;

        return $this;
    }

    /**
     * Get lead
     *
     * @return string
     */
    public function getLead()
    {
        return $this->lead;
    }
}

