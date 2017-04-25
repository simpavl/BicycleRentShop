<?php
/**
 * Created by PhpStorm.
 * User: Павел
 * Date: 09.04.2017
 * Time: 15:03
 */

namespace Admin\Controller;

use Blog\Entity\Category;
use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;
use Admin\Form\CategoryAddForm;


class CategoryController extends AbstractActionController {

    /**
     * Entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;


    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function indexAction()
    {
        //var_dump (entityManager); die();
        $query = $this->entityManager->createQuery('SELECT u FROM Blog\Entity\Category u ORDER BY u.id DESC');
        $rows = $query->getResult();
        //var_dump($rows);
        return array('category' => $rows);
    }
    public function addAction()
    {
        $form = new CategoryAddForm();
        $status = $message = '';
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {

                $category = new Category();
                $category->exchangeArray($form->getData());
                $this->entityManager->persist($category);
                $this->entityManager->flush();
                $status = 'success';
                $message = 'Категория добавлена';
            } else {
                $status = 'error';
                $message = 'Ошибка параметров';
            }
        } else {
            return array('form' => $form);

        }

        if($message){
            $this->flashMessenger()
                    ->setNamespace($status)
                    ->addMessage($message);
        }
        return $this->redirect()->toRoute('admin/category');
    }
    public function editAction()
    {
        $message = $status = '';
        $form = new CategoryAddForm();
        $id = (int) $this->params()->fromRoute('id',0);
        $category = $this->entityManager->find('Blog\Entity\Category', $id);
        if(empty($category)){
            $message = 'Категория не найдена';
            $status = 'error';
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
            return $this->redirect()->toRoute('admin/category');
        }
        $form->bind($category);

        $request = $this->getRequest();

        if($request->isPost())
        {
            $data = $request->getPost();
            $form->setData($data);
            if($form->isValid()){
                $this->entityManager->persist($category);
                $this->entityManager->flush();
                $status = 'success';
                $message = 'Категория обновлена';

            } else {
                $status = 'error';
                $message = 'Ошибка параметров';
                foreach ($form->getInputFilter()->getInvalidInput() as $errors) {
                    foreach ($errors->getMessages() as $error) {
                        $message .= ' ' . $error;
                    }
                }
            }

        } else {
            return ['form' => $form, 'id' => $id];
        }
        if($message){
            $this->flashMessenger()
                ->setNamespace($status)
                ->addMessage($message);
        }
        return $this->redirect()->toRoute('admin/category');
    }
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $status = 'success';
        $message = 'Запись удалена';
        try {
            $repository = $this->entityManager->getRepository('Blog\Entity\Category');
            $category = $repository->find($id);
            $this->entityManager->remove($category);
            $this->entityManager->flush();
        }
        catch (\Exception $ex) {
            $status = 'error';
            $message = 'Ошибка удаления записи: ' . $ex->getMessage();
        }
        $this->flashMessenger()
            ->setNamespace($status)
            ->addMessage($message);
        return $this->redirect()->toRoute('admin/category');
    }
}