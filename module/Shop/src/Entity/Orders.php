<?php

namespace Shop\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Orders
 *
 * @ORM\Table(name="orders", indexes={@ORM\Index(name="product_id", columns={"product_id"}), @ORM\Index(name="user_id", columns={"user_id"})})
 * @ORM\Entity
 */
class Orders
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
     * @var integer
     *
     * @ORM\Column(name="payment_type_id", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $paymentTypeId;

    /**
     * @var string
     *
     * @ORM\Column(name="ordercost", type="decimal", precision=15, scale=4, nullable=false, unique=false)
     */
    private $ordercost;


    /**
     * @var \Shop\Entity\Status
     *
     * @ORM\ManyToOne(targetEntity="Shop\Entity\Status")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="orderstatus", referencedColumnName="id", nullable=true)
     * })
     */
    private $orderstatus;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="Shop\Entity\OrderProducts")
     * @ORM\JoinTable(name="order_products_linker",
     *      joinColumns={@ORM\JoinColumn(name="orderid", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="productid", referencedColumnName="id")}
     * )
     */
    protected $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

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
     * @return Orders
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
     * @return Orders
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
     * @return Orders
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
     * @return Orders
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
	
	/**
     * Set orderstatus
     *
     * @param \Shop\Entity\Status $orderstatus
     *
     * @return Orders
     */
    public function setStatus(\Shop\Entity\Status $orderstatus = null)
    {
        $this->orderstatus = $orderstatus;

        return $this;
    }

    /**
     * Get orderstatus
     *
     * @return \Shop\Entity\Status
     */
    public function getStatus()
    {
        return $this->orderstatus;
    }

    /**
     * Get role.
     *
     * @return array
     */
    public function getProducts()
    {
        return $this->products->getValues();
    }

    /**
     * Add a role to the user.
     *
     * @param Product $product
     *
     * @return void
     */
    public function addProduct($product)
    {
        $this->products[] = $product;
    }
}

