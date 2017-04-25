<?php

namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Orders
 *
 * @ORM\Table(name="orders")
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
     * @ORM\Column(name="product_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $productId;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $userId;

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
     * @return Order
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
     * Set userId
     *
     * @param integer $userId
     *
     * @return Order
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
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
}

