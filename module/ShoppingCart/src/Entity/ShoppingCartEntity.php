<?php
/**
 * Basic Shopping Cart entity
 * -------------------------------------------------------
 * You can easily create your own Entity to pass any parameters you need to have in Cart.
 * Just create Cart Entity in your module, don't forget to implement ShoppingCartEntityInterface.
 * Here are 4 required fields to have Cart working: id, product, qty, price.
 *
 * @package ShoppingCart
 * @subpackage Entity
 * @author Aleksander Cyrkulewski
 */
namespace ShoppingCart\Entity;

use ShoppingCart\Entity\ShoppingCartEntityInterface;

class ShoppingCartEntity implements ShoppingCartEntityInterface
{

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $product;

    /**
     * @var int
     */
    protected $qty;

    /**
     * @var float
     */
    protected $price;

    /**
     * @var \DateTime
     */
    protected $start;

    /**
     * @var \DateTime
     */
    protected $end;

    /**
     * @var string
     */
    protected $logo;

    /**
     * @var array
     */
    protected $product_properties = array();

    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return the $product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @return the $qty
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * @return the $price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return the $start
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return the $end
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @return the $logo
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param number $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * @param number $qty
     */
    public function setQty($qty)
    {
        $this->qty = $qty;
    }

    /**
     * @param number $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @param \DateTime $start
     */
    public function setStart($start)
    {
        $this->start = $start;
    }

    /**
     * @param \DateTime $end
     */
    public function setEnd($end)
    {
        $this->end = $end;
    }

    /**
     * @param array $properties
     */
    public function setProductProperties(array $properties)
    {
        $this->product_properties = $properties;
    }

    /**
     * @return array
     */
    public function getProductProperties()
    {
        return $this->product_properties;
    }

    /**
     * @param string $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }
}