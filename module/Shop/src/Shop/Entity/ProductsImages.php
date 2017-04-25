<?php

namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductsImages
 *
 * @ORM\Table(name="products_images")
 * @ORM\Entity
 */
class ProductsImages
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
     * @var integer
     *
     * @ORM\Column(name="product_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $productId;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=100, precision=0, scale=0, nullable=false, unique=false)
     */
    private $link;


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
     * Set productId
     *
     * @param integer $productId
     *
     * @return ProductsImages
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;

        return $this;
    }

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
     * Set link
     *
     * @param string $link
     *
     * @return ProductsImages
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }
}

