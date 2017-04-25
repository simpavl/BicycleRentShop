<?php

namespace Shop\Service;

use Shop\Entity\Category;
use Zend\Filter\StaticFilter;

class CategoryManager
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

    public function addNewCategory($data)
    {
        $category = new Category();
        $category->setName($data['name']);

        $this->entityManager->persist($category);
        $this->entityManager->flush();
    }
    public function updateCategory($category,$data)
    {
        $category->setName($data['name']);
        $this->entityManager->flush();
    }
    public function removeCategory($category)
    {
        $this->entityManager->remove($category);
        $this->entityManager->flush();
    }
}