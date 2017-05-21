<?php

namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="product_image_linker", indexes={@ORM\Index(name="product_id", columns={"product_id"})})
 * @ORM\Entity
 */
class ProductImageLinker
{
    /**
     * @var \Shop\Entity\Product
     * @ORM\ManyToOne(targetEntity="Shop\Entity\Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $productid;

    /**
     * @var \Shop\Entity\ProductImage
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\ManyToOne(targetEntity="Shop\Entity\ProductImage")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="image_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $imageid;


    /**
     * Set productid
     *
     * @param \Shop\Entity\Product $productid
     *
     * @return ProductImageLinker
     */
    public function setProductid(\Shop\Entity\Product $productid = null)
    {
        $this->productid = $productid;

        return $this;
    }

    /**
     * Get productid
     *
     * @return \Shop\Entity\Product
     */
    public function getProductid()
    {
        return $this->productid;
    }

    /**
     * Set imageid
     *
     * @param \Shop\Entity\ProductImage $imageid
     *
     * @return ProductImageLinker
     */
    public function setImageid(\Shop\Entity\ProductImage $imageid = null)
    {
        $this->imageid = $imageid;

        return $this;
    }

    /**
     * Get imageid
     *
     * @return \Shop\Entity\ProductImage
     */
    public function getImageid()
    {
        return $this->imageid;
    }
}

