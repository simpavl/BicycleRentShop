<?php

namespace Shop\Controller;

use Shop\Entity\Category;
use Shop\Form\CartForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;


class CartController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Entity manager.
     * @var \Shop\Service\ProductManager
     */
    private $productManager;

    /**
     * Constructor is used for injecting dependencies into the controller.
     */
    public function __construct($entityManager,$productManager)
    {
        $this->entityManager = $entityManager;
        $this->productManager = $productManager;
    }

    public function indexAction()
    {
        $carts = $this->ShoppingCart()->cart();
        $totalcost = $this->productManager->gettotalcost($carts);
        $form = new CartForm();

        if($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();

            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                var_dump($data);
                if($data['update'])
                {
                    var_dump('UPDAAAAATE');
                }
                elseif ($data['delete'])
                {
                    var_dump('deeeeeeeeelete');
                }
                elseif ($data['order'])
                {
                    return $this->redirect()->toRoute('order');
                }
                else return false;

                //return $this->redirect()->toRoute('admin');
            }
        }
        return new ViewModel(
            [
                'carts' => $carts,
                'form' => $form,
                'totalcost' => $totalcost,
            ]);
    }
}