<?php

namespace Yaf\Model\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * SendTimes
 *
 * @ORM\Table(name="send_times")
 * @ORM\Entity(repositoryClass="Yaf\Model\Repository\SendTimesRepository")
 */
class SendTimes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="gid", type="integer", nullable=false)
     */
    private $gid;

    /**
     * @var integer
     *
     * @ORM\Column(name="uid", type="integer", nullable=false)
     */
    private $uid;

    /**
     * @var integer
     *
     * @ORM\Column(name="send_times", type="integer", nullable=false)
     */
    private $sendTimes;

    /**
     * @var integer
     *
     * @ORM\Column(name="last_send_time", type="integer", nullable=false)
     */
    private $lastSendTime;


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
     * Set gid
     *
     * @param integer $gid
     * @return SendTimes
     */
    public function setGid($gid)
    {
        $this->gid = $gid;

        return $this;
    }

    /**
     * Get gid
     *
     * @return integer
     */
    public function getGid()
    {
        return $this->gid;
    }

    /**
     * Set uid
     *
     * @param integer $uid
     * @return SendTimes
     */
    public function setUid($uid)
    {
        $this->uid = $uid;

        return $this;
    }

    /**
     * Get uid
     *
     * @return integer
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Set sendTimes
     *
     * @param integer $sendTimes
     * @return SendTimes
     */
    public function setSendTimes($sendTimes)
    {
        $this->sendTimes = $sendTimes;

        return $this;
    }

    /**
     * Get sendTimes
     *
     * @return integer
     */
    public function getSendTimes()
    {
        return $this->sendTimes;
    }

    public function incSendTimes()
    {
        $this->sendTimes += 1;
        return $this;
    }

    /**
     * Set lastSendTime
     *
     * @param integer $lastSendTime
     * @return SendTimes
     */
    public function setLastSendTime($lastSendTime)
    {
        $this->lastSendTime = $lastSendTime;

        return $this;
    }

    /**
     * Get lastSendTime
     *
     * @return integer
     */
    public function getLastSendTime()
    {
        return $this->lastSendTime;
    }
}
