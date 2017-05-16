<?php

namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductImage
 *
 * @ORM\Table(name="product_image", indexes={@ORM\Index(name="product_id", columns={"product_id"})})
 * @ORM\Entity
 */
class ProductImage
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
     * @ORM\Column(name="link", type="string", length=100, precision=0, scale=0, nullable=false, unique=false)
     */
    private $link;

    /**
     * @var \Shop\Entity\Product
     *
     * @ORM\ManyToOne(targetEntity="Shop\Entity\Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $product;


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
     * Set link
     *
     * @param string $link
     *
     * @return ProductImage
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

    /**
     * Set product
     *
     * @param \Shop\Entity\Product $product
     *
     * @return ProductImage
     */
    public function setProduct(\Shop\Entity\Product $product = null)
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
}

