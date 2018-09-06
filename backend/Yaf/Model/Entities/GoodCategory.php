<?php

namespace Yaf\Model\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * GoodCategory
 */
class GoodCategory
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $gid;

    /**
     * @var integer
     */
    private $cid;

    /**
     * @var integer
     */
    private $ctime;


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
     * @return GoodCategory
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
     * Set cid
     *
     * @param integer $cid
     * @return GoodCategory
     */
    public function setCid($cid)
    {
        $this->cid = $cid;

        return $this;
    }

    /**
     * Get cid
     *
     * @return integer 
     */
    public function getCid()
    {
        return $this->cid;
    }

    /**
     * Set ctime
     *
     * @param integer $ctime
     * @return GoodCategory
     */
    public function setCtime($ctime)
    {
        $this->ctime = $ctime;

        return $this;
    }

    /**
     * Get ctime
     *
     * @return integer 
     */
    public function getCtime()
    {
        return $this->ctime;
    }
}
