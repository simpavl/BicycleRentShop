<?php

namespace Shop\Controller;

use Shop\Entity\OrderProducts;
use Shop\Entity\Orders;
use Shop\Entity\User;
use Shop\Form\RegisterForm;
use Shop\Form\UserManageForm;
use Shop\Service\Factory\UserManagerFactory;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Result;
use Zend\Uri\Uri;
use Shop\Form\LoginForm;


class UserController extends AbstractActionController
{

    /**
     * Entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Менеджер аутентификации.
     * @var \Shop\Service\AuthManager
     */
    private $authManager;

    /**
     * Сервис аутентификации.
     * @var \Zend\Authentication\AuthenticationService
     */
    private $authService;

    /**
     * Менеджер пользователей.
     * @var \Shop\Service\UserManager
     */
    private $userManager;

    /**
     * Constructor is used for injecting dependencies into the controller.
     */
    public function __construct($entityManager, $authManager, $authService, $userManager)
    {
        $this->entityManager = $entityManager;
        $this->authManager = $authManager;
        $this->authService = $authService;
        $this->userManager = $userManager;
    }

    public function loginAction()
    {
        $redirectUrl = (string)$this->params()->fromQuery('redirectUrl', '');
        if (strlen($redirectUrl)>2048) {
            throw new \Exception("Too long redirectUrl argument passed");
        }
        $form = new LoginForm();
        $form->get('redirect_url')->setValue($redirectUrl);

        // Entrance status storage
        $isLoginError = false;
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                // Trying to log in
                $result = $this->authManager->login($data['email'],
                    $data['password'], $data['remember_me']);

                // Checking result
                 if ($result->getCode() == Result::SUCCESS) {
                     $redirectUrl = $this->params()->fromPost('redirect_url', '');
                     if (!empty($redirectUrl)) {
                         $uri = new Uri($redirectUrl);
                         if (!$uri->isValid() || $uri->getHost()!=null)
                             throw new \Exception('Incorrect redirect URL: ' . $redirectUrl);
                     }
                     if(empty($redirectUrl)) {
                         return $this->redirect()->toRoute('home');
                     } else {
                         $this->redirect()->toUrl($redirectUrl);
                     }
                 } else {
                     $isLoginError = true;
                 }
             } else {
                 $isLoginError = true;
             }
         }

        return new ViewModel([
            'form' => $form,
            'isLoginError' => $isLoginError,
            'redirectUrl' => $redirectUrl
        ]);
    }

    public function logoutAction()
    {
        $this->authManager->logout();

        return $this->redirect()->toRoute('user');
    }

    public function registrationAction()
    {
        $form = new RegisterForm();
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if($form->isValid()) {
                $data = $form->getData();
                $user = $this->userManager->registerUser($data);
                return $this->redirect()->toRoute('shop');
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }
    public function cabinetAction()
    {
        if ($this->authService->hasIdentity()) {
            $form = new UserManageForm();
            $user = $this->entityManager->getRepository(User::class)->findOneByEmail($this->authService->getIdentity());
            $orders = $this->entityManager->getRepository(Orders::class)->findBy(['user'=>$user],['id'=>'ASC']);
            $orderprods = $this->entityManager->getRepository(OrderProducts::class)->findBy(['order'=>$orders],['id'=>'ASC']);
            if ($this->getRequest()->isPost()) {
                $data = $this->params()->fromPost();

                $form->setData($data);
                if ($form->isValid()) {
                    $data = $form->getData();
                    $this->userManager->editUser($user, $data);
                }
            }
            else {
                $data = [
                    'first_name' => $user->getFirstname(),
                    'last_name' => $user->getSurname(),
                    'gender' => $user->getGenderAsString()
                ];
                $form->setData($data);
            }
            return new ViewModel(
                [
                    'form' => $form,
                    'prods' => $orderprods,
                ]);
        }
    else return $this->redirect()->toRoute('user');
    }
}

