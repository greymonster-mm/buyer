<?php

namespace Yaf\Model\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * GoodsImg
 *
 * @ORM\Table(name="goods_img")
 * @ORM\Entity
 */
class GoodsImg
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
     * @var string
     *
     * @ORM\Column(name="img_path", type="string", length=255, nullable=false)
     */
    private $imgPath;

    /**
     * @var string
     *
     * @ORM\Column(name="md5", type="string", length=32, nullable=false)
     */
    private $md5;

    /**
     * @var boolean
     *
     * @ORM\Column(name="if_valid", type="boolean", nullable=false)
     */
    private $ifValid;


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
     * @return GoodsImg
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
     * Set imgPath
     *
     * @param string $imgPath
     * @return GoodsImg
     */
    public function setImgPath($imgPath)
    {
        $this->imgPath = $imgPath;

        return $this;
    }

    /**
     * Get imgPath
     *
     * @return string 
     */
    public function getImgPath()
    {
        return $this->imgPath;
    }

    /**
     * Set md5
     *
     * @param string $md5
     * @return GoodsImg
     */
    public function setMd5($md5)
    {
        $this->md5 = $md5;

        return $this;
    }

    /**
     * Get md5
     *
     * @return string 
     */
    public function getMd5()
    {
        return $this->md5;
    }

    /**
     * Set ifValid
     *
     * @param boolean $ifValid
     * @return GoodsImg
     */
    public function setIfValid($ifValid)
    {
        $this->ifValid = $ifValid;

        return $this;
    }

    /**
     * Get ifValid
     *
     * @return boolean 
     */
    public function getIfValid()
    {
        return $this->ifValid;
    }
}
