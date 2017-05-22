<?php

namespace Shop\Controller;

use Shop\Form\SortForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ShoppingCart\Controller\Plugin\ShoppingCart;
use Shop\Entity\Product;


class ProductController extends AbstractActionController
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
    public function __construct($entityManager, $productManager)
    {
        $this->entityManager = $entityManager;
        $this->productManager = $productManager;
    }


    public function indexAction()
    {
        $prodlist = null;
        $form = new SortForm('filter',$this->entityManager);

        if($this->getRequest()->isPost()) {

            $data = $this->params()->fromPost();

            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                //$this->categoryManager->addNewCategory($data);
                $prodlist = $this->productManager->sortProducts($data);
                $form->setData([$data['start'], $data['end']]);
                //return $this->redirect()->toRoute('product');
            }
        }
        return new ViewModel([
            'form' => $form,
            'prodlist' => $prodlist
        ]);
    }

    public function testAction()
    {
        $product = array(
            'id'      => 'XYZ',
            'qty'     => 1,
            'price'   => 15.15,
            'product' => 'Bicycle',
            'start' => '07.05.2017 15:30',
            'end' => '09.05.2017 16:00',

        );
        /*$hour = date('H');
        $minute = date('i');
        if(date('i') > 30) {
            $minute = '00';
            $date = new \DateTime($hour . ':' . $minute);
            $date->add(new \DateInterval('PT1H'));
        } else {
            $minute = '30';
            $date = new \DateTime($hour . ':' . $minute);
        }

        var_dump($date->format('H:i'));*/
        $this->ShoppingCart()->insert($product);
        var_dump($this->ShoppingCart()->cart());
        foreach($this->ShoppingCart()->cart() as $token => $cart){
            var_dump($token);
        }

        return new ViewModel([
            'total_items' => $this->ShoppingCart()->total_items()
        ]);
    }

    public function viewAction()
    {
        $prodid = $this->params()->fromRoute('id', -1);
        $form = new SortForm('create',$this->entityManager);
        $product = $this->entityManager->getRepository(Product::class)->findOneById($prodid);
        if($product == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        if($this->getRequest()->isPost()) {

            $data = $this->params()->fromPost();

            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                //$this->categoryManager->addNewCategory($data);
                //$prodlist = $this->productManager->sortProducts($data);

                if( $this->productManager->checkavialablesingle($product,$data, $data['quantity'])){
                    $price = ($this->productManager->getfinalprice($this->productManager->getrentinterval($data['start'], $data['end']),
                        $product->getPrice()))*$data['quantity'];
                    $cartprod = [
                        'id' => $product->getId(),
                        'qty' => $data['quantity'],
                        'price' => $price,
                        'product' => $product->getName(),
                        'start' => $data['start'],
                        'end' => $data['end'],
                        'logo' => $product->getLogo(),
                    ];
                    $this->ShoppingCart()->insert($cartprod);
                //$form->setData([$data['start'], $data['end']]);
                return $this->redirect()->toRoute('cart');}
            }
        }
        return new ViewModel([
            'form' => $form,
            'product' => $product,
        ]);
    }
}