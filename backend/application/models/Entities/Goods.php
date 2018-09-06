<?php

namespace Yaf\Model\Entities;


use Doctrine\ORM\Mapping as ORM;

/**
 * Goods
 *
 * @ORM\Table(name="goods")
 * @ORM\Entity(repositoryClass="Yaf\Model\Repository\GoodsRepository")
 */
class Goods
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
     * @var string
     *
     * @ORM\Column(name="brand", type="string", length=255, nullable=false)
     */
    private $brand;

    /**
     * @var string
     *
     * @ORM\Column(name="product_name", type="string", length=255, nullable=false)
     */
    private $productName;

    /**
     * @var string
     *
     * @ORM\Column(name="specification", type="string", length=255, nullable=false)
     */
    private $specification;


    /**
     * @var string
     *
     * @ORM\Column(name="suggested_price", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $suggestedPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=800, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="ad_copy", type="string", length=800, nullable=false)
     */
    private $adCopy;

    /**
     * @var string
     *
     * @ORM\Column(name="updator", type="string", length=255, nullable=false)
     */
    private $updator;

    /**
     * @var string
     *
     * @ORM\Column(name="creator", type="string", length=255, nullable=false)
     */
    private $creator;

    /**
     * @var integer
     *
     * @ORM\Column(name="ctime", type="integer", nullable=false)
     */
    private $ctime;

    /**
     * @var integer
     *
     * @ORM\Column(name="utime", type="integer", nullable=false)
     */
    private $utime;

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
     * Set brand
     *
     * @param string $brand
     * @return Goods
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set productName
     *
     * @param string $productName
     * @return Goods
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;

        return $this;
    }

    /**
     * Get productName
     *
     * @return string
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * Set specification
     *
     * @param string $specification
     * @return Goods
     */
    public function setSpecification($specification)
    {
        $this->specification = $specification;

        return $this;
    }

    /**
     * Get specification
     *
     * @return string
     */
    public function getSpecification()
    {
        return $this->specification;
    }

    /**
     * Set suggestedPrice
     *
     * @param string $suggestedPrice
     * @return Goods
     */
    public function setSuggestedPrice($suggestedPrice)
    {
        $this->suggestedPrice = $suggestedPrice;

        return $this;
    }

    /**
     * Get suggestedPrice
     *
     * @return string
     */
    public function getSuggestedPrice()
    {
        return $this->suggestedPrice;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Goods
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Goods
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set adCopy
     *
     * @param string $adCopy
     * @return Goods
     */
    public function setAdCopy($adCopy)
    {
        $this->adCopy = $adCopy;

        return $this;
    }

    /**
     * Get adCopy
     *
     * @return string
     */
    public function getAdCopy()
    {
        return $this->adCopy;
    }

    /**
     * Set updator
     *
     * @param string $updator
     * @return Goods
     */
    public function setUpdator($updator)
    {
        $this->updator = $updator;

        return $this;
    }

    /**
     * Get updator
     *
     * @return string
     */
    public function getUpdator()
    {
        return $this->updator;
    }

    /**
     * Set creator
     *
     * @param string $creator
     * @return Goods
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Get creator
     *
     * @return string
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Set ctime
     *
     * @param integer $ctime
     * @return Goods
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

    /**
     * Set utime
     *
     * @param integer $utime
     * @return Goods
     */
    public function setUtime($utime)
    {
        $this->utime = $utime;

        return $this;
    }

    /**
     * Get utime
     *
     * @return integer
     */
    public function getUtime()
    {
        return $this->utime;
    }

    /**
     * Set ifValid
     *
     * @param boolean $ifValid
     * @return Goods
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
