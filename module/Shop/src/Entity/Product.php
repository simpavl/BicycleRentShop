<?php

namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Product
 *
 * @ORM\Table(name="product", indexes={@ORM\Index(name="brand_id", columns={"brand_id"}), @ORM\Index(name="category_id", columns={"category_id"}), @ORM\Index(name="subcategory_id", columns={"subcategory_id"})})
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
     * @var \Shop\Entity\Subcategory
     *
     * @ORM\ManyToOne(targetEntity="Shop\Entity\Subcategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="subcategory_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $subcategory;

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
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $quantity;


    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="text", length=65535, precision=0, scale=0, nullable=false, unique=false)
     */
    private $logo;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="Shop\Entity\ProductImage")
     * @ORM\JoinTable(name="product_image_linker",
     *      joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="image_id", referencedColumnName="id")}
     * )
     */
    protected $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

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
     * Set subcategory
     *
     * @param \Shop\Entity\Subcategory $subcategory
     *
     * @return Product
     */
    public function setSubCategory(\Shop\Entity\Subcategory $subcategory = null)
    {
        $this->subcategory = $subcategory;

        return $this;
    }

    /**
     * Get subcategory
     *
     * @return \Shop\Entity\Subcategory
     */
    public function getSubCategory()
    {
        return $this->subcategory;
    }
    /**
     * Set category
     *
     * @param \Shop\Entity\Subcategory $subcategory
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

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Product
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set logo
     *
     * @param string $logo
     *
     * @return Product
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->description;
    }

    /**
     * Get role.
     *
     * @return array
     */
    public function getImages()
    {
        return $this->images->getValues();
    }

    /**
     * Add a role to the user.
     *
     * @param Image $image
     *
     * @return void
     */
    public function addImage($image)
    {
        $this->images[] = $image;
    }
}
