<?php

namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderProducts
 *
 * @ORM\Table(name="order_products", indexes={@ORM\Index(name="product_id", columns={"product_id"}), @ORM\Index(name="order_id", columns={"order_id"})})
 * @ORM\Entity
 */
class OrderProducts
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
     * @var \Shop\Entity\Orders
     *
     * @ORM\ManyToOne(targetEntity="Shop\Entity\Orders")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $order;

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
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $quantity;

    /**
     * @var \Shop\Entity\Status
     *
     * @ORM\ManyToOne(targetEntity="Shop\Entity\Status")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status", referencedColumnName="id", nullable=true)
     * })
     */
    private $status;
	
	/**
     * @var \DateTime
     *
     * @ORM\Column(name="startdate", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $startdate;
	
	/**
     * @var \DateTime
     *
     * @ORM\Column(name="enddate", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $enddate;

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
     * Set order
     *
     * @param \Shop\Entity\Orders $order
     *
     * @return OrderProducts
     */
    public function setOrder(\Shop\Entity\Orders $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get brand
     *
     * @return \Shop\Entity\Orders
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set product
     *
     * @param \Shop\Entity\Product $product
     *
     * @return OrderProducts
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

    /**
     * Set status
     *
     * @param \Shop\Entity\Status $status
     *
     * @return OrderProducts
     */
    public function setStatus(\Shop\Entity\Status $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \Shop\Entity\Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set startdate
     *
     * @param \DateTime $startdate
     *
     * @return OrderProducts
     */
    public function setStartDate($startdate)
    {
        $this->startdate = $startdate;

        return $this;
    }

    /**
     * Get startdate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startdate;
    }

    /**
     * Set enddate
     *
     * @param \DateTime $enddate
     *
     * @return OrderProducts
     */
    public function setEndDate($enddate)
    {
        $this->enddate = $enddate;

        return $this;
    }

    /**
     * Get enddate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->enddate;
    }
	
	/**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return OrderProducts
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
}

