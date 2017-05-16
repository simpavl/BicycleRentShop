<?php

namespace Shop\Service;

use Shop\Entity\OrderProductsLinker;
use Shop\Entity\Orders;
use Shop\Entity\OrderProducts;
use Shop\Entity\Product;
use Shop\Entity\User;
use Shop\Entity\Status;
use Shop\Entity\Subcategory;
use Shop\Entity\Category;
use Zend\Filter\StaticFilter;

class OrderManager
{
    /**
     * Doctrine entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Authentication service.
     * @var Zend\Authentication\AuthenticationService
     */
    private $authService;

    // Конструктор, используемый для внедрения зависимостей в сервис.
    public function __construct($authService, $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->authService = $authService;
    }

    public function createorder($data, $products, $totalcost)
    {
        $order = new Orders();
        $linker = new OrderProductsLinker();
        $orderprods = new OrderProducts();
        $user = $this->entityManager->getRepository(User::class)->findOneByEmail($this->authService->getIdentity());
        $status = $this->entityManager->getRepository(Status::class)->findOneByName('waiting');
        $order->setUser($user);
        $order->setOrdercost($totalcost);
        $order->setStatus($status);
        $this->entityManager->persist($order);
        $this->entityManager->flush();
        $orderid = $order->getId();

        foreach($products as $token=>$product)
        {
            $neworder = $this->entityManager->getRepository(Orders::class)->findOneById($orderid);
            $orderprods->setOrder($neworder);
            $orderprods->setProduct($this->entityManager->getRepository(Product::class)->findOneById($product->getId()));
            $orderprods->setStatus($this->entityManager->getRepository(Status::class)->findOneById('1'));
            $startdate = new \DateTime($product->getStart());
            //$startdate = $startdate->format('d.m.Y H:i:s');
            $enddate = new \DateTime($product->getEnd());
            //$enddate = $enddate->format('d.m.Y H:i:s');
            $orderprods->setStartDate($startdate);
            $orderprods->setEndDate($enddate);
            $orderprods->setQuantity($product->getQty());

            $this->entityManager->persist($orderprods);
            $this->entityManager->flush();
            var_dump($orderprods);
            $linker->setOrderid($neworder);
            $linker->setProductid($orderprods);
            $this->entityManager->persist($linker);
            $this->entityManager->flush();
            $this->entityManager->clear();
        }
    }



}