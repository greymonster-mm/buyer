<?php

namespace Yaf\Model\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Goods
 */
class Goods
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $brand;

    /**
     * @var string
     */
    private $productName;

    /**
     * @var string
     */
    private $specification;

    /**
     * @var string
     */
    private $otherPrice;

    /**
     * @var string
     */
    private $suggestedPrice;

    /**
     * @var string
     */
    private $price;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $adCopy;

    /**
     * @var string
     */
    private $updator;

    /**
     * @var string
     */
    private $creator;

    /**
     * @var integer
     */
    private $ctime;

    /**
     * @var integer
     */
    private $utime;


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
     * Set otherPrice
     *
     * @param string $otherPrice
     * @return Goods
     */
    public function setOtherPrice($otherPrice)
    {
        $this->otherPrice = $otherPrice;

        return $this;
    }

    /**
     * Get otherPrice
     *
     * @return string 
     */
    public function getOtherPrice()
    {
        return $this->otherPrice;
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
}
