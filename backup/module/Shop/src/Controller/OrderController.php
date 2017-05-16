<?php

namespace Shop\Controller;

use Shop\Entity\Category;
use Shop\Form\CartForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;


class OrderController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Entity manager.
     * @var \Shop\Service\OrderManager
     */
    private $orderManager;

    /**
     * Entity manager.
     * @var \Shop\Service\ProductManager
     */
    private $productManager;
    /**
     * Constructor is used for injecting dependencies into the controller.
     */
    public function __construct($entityManager, $orderManager, $productManager)
    {
        $this->entityManager = $entityManager;
        $this->orderManager = $orderManager;
        $this->productManager = $productManager;
    }

    public function indexAction()
    {
        $carts = $this->ShoppingCart()->cart();
        $form = new CartForm();

        if($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();

            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();

                $this->orderManager->createorder($data,$carts,$this->productManager->gettotalcost($carts));
                //return $this->redirect()->toRoute('admin');
            }
        }
        return new ViewModel(
            [
                'carts' => $carts,
                'form' => $form,
            ]);
    }
}