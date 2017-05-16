<?php

namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductSpec
 *
 * @ORM\Table(name="product_spec", indexes={@ORM\Index(name="specs_category_id", columns={"specs_category_id"})})
 * @ORM\Entity
 */
class ProductSpec
{
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=100, precision=0, scale=0, nullable=false, unique=false)
     */
    private $description;

    /**
     * @var \Shop\Entity\Product
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Shop\Entity\Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $product;

    /**
     * @var \Shop\Entity\ProductSpecCategory
     *
     * @ORM\ManyToOne(targetEntity="Shop\Entity\ProductSpecCategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="specs_category_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $specsCategory;


    /**
     * Set description
     *
     * @param string $description
     *
     * @return ProductSpec
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
     * Set product
     *
     * @param \Shop\Entity\Product $product
     *
     * @return ProductSpec
     */
    public function setProduct(\Shop\Entity\Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Shop\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set specsCategory
     *
     * @param \Shop\Entity\ProductSpecCategory $specsCategory
     *
     * @return ProductSpec
     */
    public function setSpecsCategory(\Shop\Entity\ProductSpecCategory $specsCategory = null)
    {
        $this->specsCategory = $specsCategory;

        return $this;
    }

    /**
     * Get specsCategory
     *
     * @return \Shop\Entity\ProductSpecCategory
     */
    public function getSpecsCategory()
    {
        return $this->specsCategory;
    }
}

