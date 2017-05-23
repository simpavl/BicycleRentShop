<?php
namespace Shop\View\Helper;

use Shop\Entity\Category;
use Shop\Entity\Subcategory;
use Shop\Entity\User;
use Zend\View\Helper\AbstractHelper;


class CategoriesHelper extends AbstractHelper
{
    /**
     * Entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;


    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getCategories()
    {
        $categories = $this->entityManager->getRepository(Category::class)->findBy([],['id'=>'ASC']);
        $catarray = [];
        foreach ($categories as $category){
            $catarray[] = $category->getName();
        }
        return $catarray;
    }

    public function findSubcategories($category)
    {
        $subcategories = $this->entityManager->getRepository(Subcategory::class)->findBy(['category' => $category->getId()],['id'=>'ASC']);
        return $subcategories;
    }


}