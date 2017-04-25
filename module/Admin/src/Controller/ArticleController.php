<?php

namespace Admin\Controller;

use DoctrineORMModule\Service\DoctrineObjectHydratorFactory;
use Zend\Mvc\Controller\AbstractActionController;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Blog\Entity\Article;
use Admin\Form\ArticleAddForm;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class ArticleController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var \Doctrine\ORM\EntityManager;
     */
    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function indexAction()
    {
        $query = $this->entityManager->createQueryBuilder();
        $query->select('a')
            ->from('Blog\Entity\Article', 'a')
            ->orderBy('a.id','DESC');

        $adapter = new DoctrinePaginator(new ORMPaginator($query));

        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(2);
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        return ['articles'=> $paginator];
    }
    public function addAction()
    {
        $form = new ArticleAddForm($this->entityManager);
        $request = new ArticleAddForm($this->entityManager);
        $request = $this->getRequest();
        if($request->isPost())
        {
            $message = $status = '';
            $data = $request->getPost();
            $article = new Article();
            $form->setHydrator(new DoctrineHydrator($this->entityManager, '\Article'));
            $form->bind($article);
            $form->setData($data);

            if($form->isValid())
            {
                $this->entityManager->persist($article);
                $this->entityManager->flush();
                $status = 'success';
                $message = 'Статья добавлена';
            }
            else {
                $status = 'error';
                $message = 'Ошибка параметров';
                foreach ($form->getInputFilter()->getInvalidInput() as $errors) {
                    foreach ($errors->getMessages() as $error) {
                        $message .= ' ' . $error;
                    }
                }
            }
        } else {
            return ['form' => $form];
        }
        if($message) {
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
        }
        return $this->redirect()->toRoute('admin/article');

    }
    public function editAction()
    {
        $message = $status = '';
        $form = new ArticleAddForm($this->entityManager);

        $id = (int) $this->params()->fromRoute('id', 0);
        $article = $this->entityManager->find('Blog\Entity\Article', $id);

        if(empty($article)){
            $message = 'Статья не найдена';
            $status = 'error';
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
            return $this->redirect()->toRoute('admin/article');
        }

        $form->setHydrator(new DoctrineHydrator($this->entityManager, '\Article'));
        $form->bind($article);
        $request = $this->getRequest();
        if($request->isPost())
        {
            $data = $request->getPost();
            $form->setData($data);
            if($form->isValid()){
                $this->entityManager->persist($article);
                $this->entityManager->flush();

                $status= 'success';
                $message= 'Статья обновлена';

            }else {
                $status = 'error';
                $message = 'Ошибка параметров';
                foreach ($form->getInputFilter()->getInvalidInput() as $errors) {
                    foreach ($errors->getMessages() as $error){
                        $message .= ' ' . $error;
                    }
                }
            }
        }else {
            return ['form'=>$form, 'id' => $id];
        }
        if($message){
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
        }
        return $this->redirect()->toRoute('admin/article');
    }
    public function deleteAction(){
        $id = (int) $this->params()->fromRoute('id', 0);
        $status = 'success';
        $message = 'Запись удалена';

        try {
            $repository = $this->entityManager->getRepository('Blog\Entity\Article');
            $article = $repository->find($id);
            $this->entityManager->remove($article);
            $this->entityManager->flush();
        }
        catch (\Exception $ex){
            $status = 'error';
            $message = 'Ошибка удаления записи: ' . $ex->getMessage();
        }
        $this->flashMessenger()->setNamespace($status)->addMessage($message);
        return $this->redirect()->toRoute('admin/article');
    }
}