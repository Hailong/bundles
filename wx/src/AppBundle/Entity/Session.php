<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Session
 *
 * @ORM\Table(name="sessions", options={"collate":"utf8_bin", "charset":"utf8"})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SessionRepository")
 */
class Session
{
    /**
     * @var binary
     *
     * @ORM\Column(name="sess_id", type="binary")
     * @ORM\Id
     */
    private $sessId;

    /**
     * @var string
     *
     * @ORM\Column(name="sess_data", type="blob")
     */
    private $sessData;

    /**
     * @var int
     *
     * @ORM\Column(name="sess_time", type="integer")
     */
    private $sessTime;

    /**
     * @var int
     *
     * @ORM\Column(name="sess_lifetime", type="integer")
     */
    private $sessLifetime;


    /**
     * Set sessId
     *
     * @param binary $sessId
     *
     * @return Session
     */
    public function setSessId($sessId)
    {
        $this->sessId = $sessId;

        return $this;
    }

    /**
     * Get sessId
     *
     * @return binary
     */
    public function getSessId()
    {
        return $this->sessId;
    }

    /**
     * Set sessData
     *
     * @param string $sessData
     *
     * @return Session
     */
    public function setSessData($sessData)
    {
        $this->sessData = $sessData;

        return $this;
    }

    /**
     * Get sessData
     *
     * @return string
     */
    public function getSessData()
    {
        return $this->sessData;
    }

    /**
     * Set sessTime
     *
     * @param integer $sessTime
     *
     * @return Session
     */
    public function setSessTime($sessTime)
    {
        $this->sessTime = $sessTime;

        return $this;
    }

    /**
     * Get sessTime
     *
     * @return int
     */
    public function getSessTime()
    {
        return $this->sessTime;
    }

    /**
     * Set sessLifetime
     *
     * @param integer $sessLifetime
     *
     * @return Session
     */
    public function setSessLifetime($sessLifetime)
    {
        $this->sessLifetime = $sessLifetime;

        return $this;
    }

    /**
     * Get sessLifetime
     *
     * @return int
     */
    public function getSessLifetime()
    {
        return $this->sessLifetime;
    }
}

