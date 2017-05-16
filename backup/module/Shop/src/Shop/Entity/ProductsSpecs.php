<?php

namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductsSpecs
 *
 * @ORM\Table(name="products_specs")
 * @ORM\Entity
 */
class ProductsSpecs
{
    /**
     * @var integer
     *
     * @ORM\Column(name="product_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $productId;

    /**
     * @var integer
     *
     * @ORM\Column(name="specs_category_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $specsCategoryId;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=100, precision=0, scale=0, nullable=false, unique=false)
     */
    private $description;


    /**
     * Get productId
     *
     * @return integer
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * Set specsCategoryId
     *
     * @param integer $specsCategoryId
     *
     * @return ProductsSpecs
     */
    public function setSpecsCategoryId($specsCategoryId)
    {
        $this->specsCategoryId = $specsCategoryId;

        return $this;
    }

    /**
     * Get specsCategoryId
     *
     * @return integer
     */
    public function getSpecsCategoryId()
    {
        return $this->specsCategoryId;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return ProductsSpecs
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
}

