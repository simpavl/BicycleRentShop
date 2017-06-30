<?php

namespace Shop\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use DoctrineModule\Paginator\Adapter\Collection;
use Shop\Entity\Category;
use Shop\Form\SortForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;


class IndexController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Entity manager.
     * @var \Shop\Service\IndexManager
     */
    private $indexManager;

    /**
     * Entity manager.
     * @var \Shop\Service\ProductManager
     */
    private $productManager;

    /**
     * Constructor is used for injecting dependencies into the controller.
     */
    public function __construct($entityManager,$indexManager, $productManager)
    {
        $this->entityManager = $entityManager;
        $this->indexManager = $indexManager;
        $this->productManager = $productManager;
    }

    public function indexAction()
    {
       $catid = $this->entityManager->getRepository(Category::class)->findAll();

       return new ViewModel(['catid' => $catid]);
    }

    public function categoryAction()
    {
        $form = new SortForm('filter',$this->entityManager);
        $catid = $this->params()->fromRoute('id', -1);
        $page = $this->params()->fromQuery('page', 1);
        if($this->getRequest()->isPost()) {

            $data = $this->params()->fromPost();

            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                //$this->categoryManager->addNewCategory($data);
                $prodlist = $this->productManager->sortProducts($catid,null,$data);
                $form->setData([$data['start'], $data['end']]);
                //$adapter = new DoctrineAdapter(new ORMPaginator($prodlist,false));
                $collection = new ArrayCollection($prodlist);
                $adapter = new Collection($collection);
                $paginator = new Paginator($adapter);
                $paginator->setDefaultItemCountPerPage(3);
                $paginator->setCurrentPageNumber($page);
                //return $this->redirect()->toRoute('product');
            }
        }
        else{
            $query = $this->indexManager->findProductsByCat($catid);
            $adapter = new DoctrineAdapter(new ORMPaginator($query,false));
            $paginator = new Paginator($adapter);
            $paginator->setDefaultItemCountPerPage(3);
            $paginator->setCurrentPageNumber($page);
        }
        $categories = $this->entityManager->getRepository(Category::class)->findAll();
        return new ViewModel([
            'products' => $paginator,
            'categories' => $categories,
            'catid' => $catid,
            'form' => $form,
        ]);
    }
    public function subcategoryAction()
    {
        $form = new SortForm('filter',$this->entityManager);
        $catid = $this->params()->fromRoute('id', -1);
        $subcatid = $this->params()->fromRoute('subid', -1);
        $page = $this->params()->fromQuery('page', 1);
        if($this->getRequest()->isPost()) {

            $data = $this->params()->fromPost();
            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                $prodlist = $this->productManager->sortProducts($catid,$subcatid,$data);
                $form->setData([$data['start'], $data['end']]);
                $collection = new ArrayCollection($prodlist);
                $adapter = new Collection($collection);
                $paginator = new Paginator($adapter);
                $paginator->setDefaultItemCountPerPage(9);
                $paginator->setCurrentPageNumber($page);
            }
        }
        else{
            $query = $this->indexManager->findProductsBySubCat($catid,$subcatid);
            $adapter = new DoctrineAdapter(new ORMPaginator($query,false));
            $paginator = new Paginator($adapter);
            $paginator->setDefaultItemCountPerPage(9);
            $paginator->setCurrentPageNumber($page);
        }
        $categories = $this->entityManager->getRepository(Category::class)->findAll();
        return new ViewModel([
            'products' => $paginator,
            'categories' => $categories,
            'catid' => $catid,
            'subid' => $subcatid,
            'form' => $form,
        ]);
    }
}