<?php

namespace Shop\Service;

use Shop\Entity\Orders;
use Shop\Entity\OrderProducts;
use Shop\Entity\Product;
use Shop\Entity\ProductImage;
use Shop\Entity\ProductImageLinker;
use Shop\Entity\Subcategory;
use Shop\Entity\Category;
use Zend\Filter\StaticFilter;

class ProductManager
{
    /**
     * Doctrine entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    // Конструктор, используемый для внедрения зависимостей в сервис.
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addNewProduct($data)
    {
        $product = new Product();
        $product->setName($data['name']);
        $product->setPrice($data['price']);
        $product->setDescription($data['description']);
        $product->setQuantity($data['quantity']);
        $subcategory = $this->entityManager->getRepository(Subcategory::class)->findOneById($data['category']);
        $category = $subcategory->getCategory();
        $product->setCategory($category);
        $product->setSubCategory($subcategory);
        $tmp_name = basename($data['image-file']['tmp_name']);
        $product->setLogo('/img/' . $tmp_name);
        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }
    public function updateProduct($product,$data)
    {
        $product->setName($data['name']);
        $product->setPrice($data['price']);
        $product->setDescription($data['description']);
        $product->setQuantity($data['quantity']);
        $subcategory = $this->entityManager->getRepository(Subcategory::class)->findOneById($data['category']);
        $category = $subcategory->getCategory();
        $product->setCategory($category);
        $product->setSubCategory($subcategory);

        $this->entityManager->flush();
    }
    public function removeProduct($product)
    {
        $this->entityManager->remove($product);
        $this->entityManager->flush();
    }

    public function addNewProductImages($data,$prodid)
    {
        $product_image = new ProductImage();
        $product_image_linker = new ProductImageLinker();
        foreach($data['image-file'] as $image){
            $product = $this->entityManager->getRepository(Product::class)->findOneById($prodid);
            $tmp_name = basename($image['tmp_name']);
            $product_image->setProduct($product);
            $product_image->setLink('/img/' . $tmp_name);
            $this->entityManager->persist($product_image);
            $this->entityManager->flush();
            $product_image_linker->setProductid($product);
            $product_image_linker->setImageid($product_image);
            $this->entityManager->persist($product_image_linker);
            $this->entityManager->flush();
            $this->entityManager->clear();
        }
    }

    public function replaceProductImage($data,$prodimg)
    {
            $tmp_name = basename($data['image-file']['tmp_name']);
            $prodimg->setLink('/img/' . $tmp_name);
            $this->entityManager->flush();
    }

    public function removeProdimg($prodimg,$linker)
    {
        $this->entityManager->remove($linker);
        $this->entityManager->remove($prodimg);
        $this->entityManager->flush();
    }

    public function sortProducts($data)
    {
        $products = new Product();
        $subcategory = $this->entityManager->getRepository(Subcategory::class)->findOneById($data['category']);
        $category = $subcategory->getCategory()->getId();
        $subcategory = $subcategory->getId();
        //Getting Products Objects with filtered by user category
        $prodlist = $this->entityManager->getRepository(Product::class)->findBy(['category'=>$category, 'subcategory'=>$subcategory],['id'=>'ASC']);
        //Getting object array with available products
        $prodlist = $this->checkavialable($prodlist, $data);
        //Getting object array with products that we can allow client to rent
        return $prodlist;
    }

    //
    public function checkavialable($prodlist, $data)
    {
        $prodcount = [];
        $validprodlist = [];
        //var_dump($this->entityManager->getRepository(Orders::class)->findOneById('11')->getProducts());
        foreach ($prodlist as $product)
        {
            //getting array of active orders and that fits product id objects
            $ordprods = $this->entityManager->getRepository(OrderProducts::class)->findBy(['product' => $product->getId(), 'status' => 2],['id'=>'ASC']);
            //getting number of products in use during select by user range
            if(($quantity = $this->checkordprods($ordprods, $data))){

                //checking if we can provide this product to the client or we'll be out of stock
                if($this->checkinstock($quantity, $product)){
                    $prodcount = [$product->getId()];
                }
            }else {
                $prodcount = [$product->getId()];
            }
        }
        foreach($prodcount as $prod)
        {
            $validprodlist = [$this->entityManager->getRepository(Product::class)->findOneById($prod)];
        }
        return $validprodlist;
    }

    public function checkordprods($ordprods, $data)
    {
        $occupiedquantity = null;
        foreach($ordprods as $ordprod)
        {
            $usrstartdate = $data['start'];
            $usrenddate = $data['end'];
            $startdate = $ordprod->getStartDate();
            $startdate = $startdate->format('d.m.Y H:i');
            $enddate = $ordprod->getEndDate();
            $enddate = $enddate->format('d.m.Y H:i');
            //var_dump(strtotime($usrstartdate));
            $checkdata = ['usrstart'=>strtotime($usrstartdate),'usrend'=>strtotime($usrenddate),
                'start'=>strtotime($startdate),'end'=>strtotime($enddate)];
            //getting info about select by user range, is it between this active order range, if yes getting total amount of products that will be used during this range
            if($this->checkinrange($checkdata)){
                $occupiedquantity += $ordprod->getQuantity();
            }


        }
        return $occupiedquantity;

    }

    public function checkinrange($checkdata)
    {
        return ((($checkdata['usrstart'] >= $checkdata['start']) && ($checkdata['usrstart'] <= $checkdata['end'])) || (($checkdata['usrend'] >= $checkdata['start']) && ($checkdata['usrend'] <= $checkdata['end'])));
    }

    public function checkinstock($quantity, $product, $qty)
    {
        $prodquant = $product->getQuantity();
        if($prodquant>($quantity+$qty)){
            return true;
        }else return false;
    }

    public function checkavialablesingle($product, $data, $qty)
    {
        $prodcount = [];
        $validprodlist = [];
            //getting array of active orders and that fits product id objects
            $ordprods = $this->entityManager->getRepository(OrderProducts::class)->findBy(['product' => $product->getId(), 'status' => 2],['id'=>'ASC']);
            //getting number of products in use during select by user range
            if(($quantity = $this->checkordprods($ordprods, $data))){
                //checking if we can provide this product to the client or we'll be out of stock
                if(($this->checkinstock($quantity, $product, $qty))){
                    return true;
                }
            }
            else return true;
        return false;
    }

    public function getrentinterval($start, $end)
    {
        $start = new \DateTime($start);
        $end = new \DateTime($end);
        $diff = $end->diff($start);
        $hours = $diff->h;
        $hours = $hours + ($diff->days*24);
        return $hours;
    }

    public function getfinalprice($hours, $price)
    {
        $totalprice = null;
        if($hours>5 && $hours<24){
         $totalprice = $hours*$price;
         $totalprice = $totalprice - ($totalprice * 0.2);
        }
        elseif($hours>=24){
            $totalprice = $hours*$price;
            $totalprice = $totalprice - ($totalprice * 0.4);
        }
        else $totalprice = $hours*$price;
        return $totalprice;
    }

    public function gettotalcost($products)
    {
        $totalcost = null;
        foreach($products as $token => $product)
        {
            $totalcost += $product->getPrice();
        }
        return $totalcost;
    }



}