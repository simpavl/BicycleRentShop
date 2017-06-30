<?php

namespace Shop\Service;

use Shop\Entity\Category;
use Shop\Entity\Product;
use Shop\Entity\Subcategory;
use Zend\Filter\StaticFilter;

class IndexManager
{
    /**
     * Doctrine entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findProductsByCat($catid)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder->select('p')->from(Product::class,'p')->where('p.category = ?1')
            ->orderBy('p.id','ASC')
            ->setParameter('1',$catid);
        return $queryBuilder->getQuery();

    }
    public function findProductsBySubCat($catid,$subcatid)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder->select('p')->from(Product::class,'p')
            ->where('p.category = ?1')
            ->andWhere('p.subcategory = ?2')
            ->orderBy('p.id','ASC')
            ->setParameter('1', $catid)
            ->setParameter('2',$subcatid);

        return $queryBuilder->getQuery();
    }

}