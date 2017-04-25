<?php

namespace Shop\Controller;

use Shop\Form\CategoryForm;
use Shop\Form\UserForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Shop\Entity\Category;
use Shop\Entity\User;

class AdminController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Constructor is used for injecting dependencies into the controller.
     */

    /**
     * AdminController constructor.
     * @var \Shop\Service\CategoryManager
     */

    private $categoryManager;

    /**
     * AdminController constructor.
     * @var \Shop\Service\UserManager
     */

    private $userManager;

    public function __construct($entityManager, $categoryManager, $userManager)
    {
        $this->entityManager = $entityManager;
        $this->categoryManager = $categoryManager;
        $this->userManager = $userManager;
    }

    public function indexAction()
    {
        $categories = $this->entityManager->getRepository(Category::class)->findBy([], ['id'=>'ASC']);
        $users = $this->entityManager->getRepository(User::class)->findBy([], ['id' => 'ASC']);
        return new ViewModel([
            'categories' => $categories,
            'categoryManager' => $this->categoryManager,
            'users' => $users
        ]);
    }

    public function addCategoryAction()
    {
        $form = new CategoryForm();

        if($this->getRequest()->isPost()) {

            $data = $this->params()->fromPost();

            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                $this->categoryManager->addNewCategory($data);

                return $this->redirect()->toRoute('shop');
            }
        }
        return new ViewModel([
            'form' => $form
        ]);
    }
    public function editCategoryAction()
    {
        $form = new CategoryForm();

        $catid = $this->params()->fromRoute('id', -1);

        $category = $this->entityManager->getRepository(Category::class)->findOneById($catid);
        if($category == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        if($this->getRequest()->isPost()) {

            $data = $this->params()->fromPost();

            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                $this->categoryManager->updateCategory($category,$data);

                return $this->redirect()->toRoute('shop');
            }
        } else {
            $data = [
                'name' => $category->getName()
            ];
            $form->setData($data);
        }
        return new ViewModel([
            'form' => $form,
            'category' => $category
        ]);
    }
    public function deleteCategoryAction()
    {
        $catid = $this->params()->fromRoute('id', -1);
        $category = $this->entityManager->getRepository(Category::class)->findOneById($catid);
        if($category == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $this->categoryManager->removeCategory($category);
        return $this->redirect()->toRoute('shop');
    }
    public function usersListAction()
    {
        $users = $this->entityManager->getRepository(User::class)->findBy([], ['id' => 'ASC']);
        return new ViewModel([
            'users' => $users
        ]);
    }

    public function addUserAction()
    {
        // Create user form
        $form = new UserForm('create', $this->entityManager);

        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {

            // Fill in the form with POST data
            $data = $this->params()->fromPost();

            $form->setData($data);

            // Validate form
            if($form->isValid()) {

                // Get filtered and validated data
                $data = $form->getData();

                // Add user.
                $user = $this->userManager->addUser($data);

                // Redirect to "view" page
                return $this->redirect()->toRoute('admin',
                    ['action'=>'view-user', 'id'=>$user->getId()]);
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }
    public function viewUserAction()
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        // Find a user with such ID.
        $user = $this->entityManager->getRepository(User::class)
            ->find($id);

        if ($user == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        return new ViewModel([
            'user' => $user
        ]);
    }
    public function editUserAction()
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $user = $this->entityManager->getRepository(User::class)
            ->find($id);

        if ($user == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        // Create user form
        $form = new UserForm('update', $this->entityManager, $user);

        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {

            // Fill in the form with POST data
            $data = $this->params()->fromPost();

            $form->setData($data);

            // Validate form
            if($form->isValid()) {

                // Get filtered and validated data
                $data = $form->getData();

                // Update the user.
                $this->userManager->updateUser($user, $data);

                // Redirect to "view" page
                return $this->redirect()->toRoute('admin',
                    ['action'=>'view-user', 'id'=>$user->getId()]);
            }
        } else {
            $form->setData(array(
                'first_name'=>$user->getFirstName(),
                'last_name'=>$user->getSurName(),
                'email'=>$user->getEmail(),
                'status'=>$user->getUseractive(),
                'gender'=>$user->getGender(),
            ));
        }

        return new ViewModel(array(
            'user' => $user,
            'form' => $form
        ));
    }
    public function changeUserPasswordAction()
    {

    }

}