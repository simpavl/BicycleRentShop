<?php

namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product", indexes={@ORM\Index(name="brand_id", columns={"brand_id"}), @ORM\Index(name="category_id", columns={"category_id"})})
 * @ORM\Entity
 */
class Product
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=200, precision=0, scale=0, nullable=false, unique=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="price", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, precision=0, scale=0, nullable=false, unique=false)
     */
    private $description;

    /**
     * @var \Shop\Entity\Brand
     *
     * @ORM\ManyToOne(targetEntity="Shop\Entity\Brand")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="brand_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $brand;

    /**
     * @var \Shop\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="Shop\Entity\Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $category;


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
     * Set name
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
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
     * Set brand
     *
     * @param \Shop\Entity\Brand $brand
     *
     * @return Product
     */
    public function setBrand(\Shop\Entity\Brand $brand = null)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return \Shop\Entity\Brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set category
     *
     * @param \Shop\Entity\Category $category
     *
     * @return Product
     */
    public function setCategory(\Shop\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Shop\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}

