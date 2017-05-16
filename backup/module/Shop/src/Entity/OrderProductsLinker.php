<?php

namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="order_products_linker", indexes={@ORM\Index(name="orderid", columns={"orderid"})})
 * @ORM\Entity
 */
class OrderProductsLinker
{
    /**
     * @var \Shop\Entity\Orders
     *
     * @ORM\ManyToOne(targetEntity="Shop\Entity\Orders")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="orderid", referencedColumnName="id", nullable=true)
     * })
     */
    private $orderid;

    /**
     * @var \Shop\Entity\OrderProducts
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\ManyToOne(targetEntity="Shop\Entity\OrderProducts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="productid", referencedColumnName="id", nullable=true)
     * })
     */
    private $productid;


    /**
     * Set orderid
     *
     * @param \Shop\Entity\Orders $orderid
     *
     * @return OrderProductsLinker
     */
    public function setOrderid(\Shop\Entity\Orders $orderid = null)
    {
        $this->orderid = $orderid;

        return $this;
    }

    /**
     * Get orderid
     *
     * @return \Shop\Entity\Orders
     */
    public function getOrderid()
    {
        return $this->orderid;
    }

    /**
     * Set productid
     *
     * @param \Shop\Entity\OrderProducts $productid
     *
     * @return OrderProductsLinker
     */
    public function setProductid(\Shop\Entity\OrderProducts $productid = null)
    {
        $this->productid = $productid;

        return $this;
    }

    /**
     * Get productid
     *
     * @return \Shop\Entity\OrderProducts
     */
    public function getProductid()
    {
        return $this->productid;
    }
}

