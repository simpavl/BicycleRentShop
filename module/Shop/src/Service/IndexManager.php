<?php

namespace Shop\Service;

use Shop\Entity\Category;
use Shop\Entity\Subcategory;
use Zend\Filter\StaticFilter;

class IndexManager
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

    public function findCategories()
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder->select('p')->from(Category::class,'p')->orderBy('p.id','ASC');

        return $queryBuilder->getQuery();
    }

}