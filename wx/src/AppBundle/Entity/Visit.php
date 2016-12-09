<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Page;

/**
 * Visit
 *
 * @ORM\Table(name="visits")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VisitRepository")
 */
class Visit
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
     * @ORM\Column(name="sess_id", type="string", length=255)
     */
    private $sessId;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="text")
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="referer", type="text", nullable=true)
     */
    private $referer;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_hit", type="datetime")
     */
    private $dateHit;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_left", type="datetime", nullable=true)
     */
    private $dateLeft;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=255, nullable=true)
     */
    private $ip;

    /**
     * @var string
     *
     * @ORM\Column(name="user_agent", type="text", nullable=true)
     */
    private $userAgent;

    /**
     * @ORM\ManyToOne(targetEntity="Device")
     * @ORM\JoinColumn(name="device_id", referencedColumnName="id")
     */
    private $device;


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
     * Set sessId
     *
     * @param string $sessId
     *
     * @return Visit
     */
    public function setSessId($sessId)
    {
        $this->sessId = $sessId;

        return $this;
    }

    /**
     * Get sessId
     *
     * @return string
     */
    public function getSessId()
    {
        return $this->sessId;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Visit
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set referer
     *
     * @param string $referer
     *
     * @return Visit
     */
    public function setReferer($referer)
    {
        $this->referer = $referer;

        return $this;
    }

    /**
     * Get referer
     *
     * @return string
     */
    public function getReferer()
    {
        return $this->referer;
    }

    /**
     * Set dateHit
     *
     * @param \DateTime $dateHit
     *
     * @return Visit
     */
    public function setDateHit($dateHit)
    {
        $this->dateHit = $dateHit;

        return $this;
    }

    /**
     * Get dateHit
     *
     * @return \DateTime
     */
    public function getDateHit()
    {
        return $this->dateHit;
    }

    /**
     * Set dateLeft
     *
     * @param \DateTime $dateLeft
     *
     * @return Visit
     */
    public function setDateLeft($dateLeft)
    {
        $this->dateLeft = $dateLeft;

        return $this;
    }

    /**
     * Get dateLeft
     *
     * @return \DateTime
     */
    public function getDateLeft()
    {
        return $this->dateLeft;
    }

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return Visit
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set userAgent
     *
     * @param string $userAgent
     *
     * @return Visit
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    /**
     * Get userAgent
     *
     * @return string
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    public function setDevice($device)
    {
        $this->device = $device;

        return $this;
    }

    public function getDevice()
    {
        return $this->device;
    }
}

