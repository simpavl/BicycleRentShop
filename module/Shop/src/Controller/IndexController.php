<?php

namespace Shop\Controller;

use Shop\Entity\Category;
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
     * Constructor is used for injecting dependencies into the controller.
     */
    public function __construct($entityManager,$indexManager)
    {
        $this->entityManager = $entityManager;
        $this->indexManager = $indexManager;
    }

    public function indexAction()
    {
       $catid = $this->entityManager->getRepository(Category::class)->findAll();

       return new ViewModel(['catid' => $catid]);
    }

    public function categoryAction()
    {
        $catid = $this->params()->fromRoute('id', -1);
        $page = $this->params()->fromQuery('page', 1);
        $query = $this->indexManager->findCategories();
        $adapter = new DoctrineAdapter(new ORMPaginator($query,false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(9);
        $paginator->setCurrentPageNumber($page);
        //$categories = $this->entityManager->getRepository(Category::class)->findAll();
        return new ViewModel([
            'categories' => $paginator,
            'test' => $paginator,
            'catid' => $catid
        ]);
    }
}