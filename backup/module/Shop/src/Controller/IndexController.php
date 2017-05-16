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
     * Constructor is used for injecting dependencies into the controller.
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function indexAction()
    {
       $catid = $this->entityManager->getRepository(Category::class)->findAll();

       return new ViewModel(['catid' => $catid]);
    }
}