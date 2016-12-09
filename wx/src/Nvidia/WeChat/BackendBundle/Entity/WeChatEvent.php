<?php

namespace Nvidia\WeChat\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WeChatEvent
 *
 * @ORM\Table(name="wechat_events")
 * @ORM\Entity(repositoryClass="Nvidia\WeChat\BackendBundle\Repository\WeChatEventRepository")
 */
class WeChatEvent
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
     * @ORM\Column(name="event", type="string", length=255)
     */
    private $event;

    /**
     * @var string
     *
     * @ORM\Column(name="eventCode", type="string", length=255, unique=true)
     */
    private $eventCode;

    /**
     * @var string
     *
     * @ORM\Column(name="toUserName", type="string", length=255)
     */
    private $toUserName;

    /**
     * @var string
     *
     * @ORM\Column(name="fromUserName", type="string", length=255)
     */
    private $fromUserName;

    /**
     * @var string
     *
     * @ORM\Column(name="createTime", type="string", length=255)
     */
    private $createTime;

    /**
     * @var string
     *
     * @ORM\Column(name="registerTime", type="string", length=255, nullable=true)
     */
    private $registerTime;


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
     * Set event
     *
     * @param string $event
     *
     * @return WeChatEvent
     */
    public function setEvent($event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return string
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set eventCode
     *
     * @param string $eventCode
     *
     * @return Xiaoan
     */
    public function setEventCode($eventCode)
    {
        $this->eventCode = $eventCode;

        return $this;
    }

    /**
     * Get eventCode
     *
     * @return string
     */
    public function getEventCode()
    {
        return $this->eventCode;
    }

    /**
     * Set toUserName
     *
     * @param string $toUserName
     *
     * @return WeChatEvent
     */
    public function setToUserName($toUserName)
    {
        $this->toUserName = $toUserName;

        return $this;
    }

    /**
     * Get toUserName
     *
     * @return string
     */
    public function getToUserName()
    {
        return $this->toUserName;
    }

    /**
     * Set fromUserName
     *
     * @param string $fromUserName
     *
     * @return WeChatEvent
     */
    public function setFromUserName($fromUserName)
    {
        $this->fromUserName = $fromUserName;

        return $this;
    }

    /**
     * Get fromUserName
     *
     * @return string
     */
    public function getFromUserName()
    {
        return $this->fromUserName;
    }

    /**
     * Set createTime
     *
     * @param string $createTime
     *
     * @return WeChatEvent
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;

        return $this;
    }

    /**
     * Get createTime
     *
     * @return string
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * Set registerTime
     *
     * @param string $registerTime
     *
     * @return WeChatEvent
     */
    public function setRegisterTime($registerTime)
    {
        $this->registerTime = $registerTime;

        return $this;
    }

    /**
     * Get registerTime
     *
     * @return string
     */
    public function getRegisterTime()
    {
        return $this->registerTime;
    }
}

