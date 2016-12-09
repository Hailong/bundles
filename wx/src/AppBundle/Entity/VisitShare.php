<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VisitShare
 *
 * @ORM\Table(name="visits_shares")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VisitShareRepository")
 */
class VisitShare
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
     * @ORM\Column(name="token", type="string", length=255, unique=true, nullable=true)
     */
    private $token;

    /**
     * @ORM\ManyToOne(targetEntity="Visit")
     * @ORM\JoinColumn(name="visit_id", referencedColumnName="id")
     */
    private $visit;

    /**
     * @ORM\OneToOne(targetEntity="Share")
     * @ORM\JoinColumn(name="to_share_id", referencedColumnName="id")
     */
    private $toShare;

    /**
     * @ORM\ManyToOne(targetEntity="Share")
     * @ORM\JoinColumn(name="from_share_id", referencedColumnName="id")
     */
    private $fromShare;


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
     * Set token
     *
     * @param string $token
     *
     * @return VisitShare
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    public function setVisit($visit)
    {
        $this->visit = $visit;

        return $this;
    }

    public function getVisit()
    {
        return $this->visit;
    }

    public function setToShare($share)
    {
        $this->toShare = $share;

        return $this;
    }

    public function getToShare()
    {
        return $this->toShare;
    }

    public function setFromShare($share)
    {
        $this->fromShare = $share;

        return $this;
    }

    public function getFromShare()
    {
        return $this->fromShare;
    }
}

