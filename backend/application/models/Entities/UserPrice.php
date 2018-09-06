<?php

namespace Yaf\Model\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserPrice
 *
 * @ORM\Table(name="user_price")
 * @ORM\Entity
 */
class UserPrice
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
     * @var string
     *
     * @ORM\Column(name="user_price", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $userPrice;


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
     * @return UserPrice
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
     * @return UserPrice
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
     * Set userPrice
     *
     * @param string $userPrice
     * @return UserPrice
     */
    public function setUserPrice($userPrice)
    {
        $this->userPrice = $userPrice;

        return $this;
    }

    /**
     * Get userPrice
     *
     * @return string
     */
    public function getUserPrice()
    {
        return $this->userPrice;
    }
}
