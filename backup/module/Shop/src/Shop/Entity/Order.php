<?php

namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Order
 *
 * @ORM\Table(name="order", indexes={@ORM\Index(name="product_id", columns={"product_id"}), @ORM\Index(name="user_id", columns={"user_id"})})
 * @ORM\Entity
 */
class Order
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
     * @ORM\Column(name="payment_type_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $paymentTypeId;

    /**
     * @var string
     *
     * @ORM\Column(name="ordercost", type="decimal", precision=15, scale=4, nullable=false, unique=false)
     */
    private $ordercost;

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
     * @var \Shop\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Shop\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $user;


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
     * Set paymentTypeId
     *
     * @param integer $paymentTypeId
     *
     * @return Order
     */
    public function setPaymentTypeId($paymentTypeId)
    {
        $this->paymentTypeId = $paymentTypeId;

        return $this;
    }

    /**
     * Get paymentTypeId
     *
     * @return integer
     */
    public function getPaymentTypeId()
    {
        return $this->paymentTypeId;
    }

    /**
     * Set ordercost
     *
     * @param string $ordercost
     *
     * @return Order
     */
    public function setOrdercost($ordercost)
    {
        $this->ordercost = $ordercost;

        return $this;
    }

    /**
     * Get ordercost
     *
     * @return string
     */
    public function getOrdercost()
    {
        return $this->ordercost;
    }

    /**
     * Set product
     *
     * @param \Shop\Entity\Product $product
     *
     * @return Order
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
     * Set user
     *
     * @param \Shop\Entity\User $user
     *
     * @return Order
     */
    public function setUser(\Shop\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Shop\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}

