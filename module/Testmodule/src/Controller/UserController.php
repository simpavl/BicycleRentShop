<?php

namespace Testmodule\Controller;

use Testmodule\Entity\User;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Testmodule\Form\UserForm;
use Zend\View\Model\JsonModel;
use CirclicalUser\Mapper\UserMapper;
use CirclicalUser\Service\AccessService;
use Zend\Json\Json;


class UserController extends AbstractActionController
{
    private $userMapper;

    private $accessService;

    public function __construct(AccessService $accessService, UserMapper $userMapper)
    {
        $this->accessService = $accessService;
        $this->userMapper = $userMapper;
    }

    public function loginAction()
    {

            $request = $this->getRequest();
            $form = new UserForm();
            if ($request->isPost()) {
            $post = $this->params()->fromPost();
            $form->setData($post);

            if ($form->isValid()) {
                $test = new User();
                $user = $form->getObject();

                //$user = $form->getObject();

                $this->userMapper->save($user);
                $this->accessService->setUser($user);

                //$this->accessService->addRoleByName('user');


                $this->auth()->create($user, $user->getEmail(), $form->get('password')->getValue());

                return [
                    'success' => true,
                    'user_id' => $user->getId(),
                ];
            } else {
                return [
                    'form' => $form,
                    'success' => false,
                    'message' => "Sorry, we weren't able to make it happen. Check the form for errors.",
                    'form_errors' => $form->getMessages(),
                ];
            }}
            return [
                'form' => $form
            ];

    }

}