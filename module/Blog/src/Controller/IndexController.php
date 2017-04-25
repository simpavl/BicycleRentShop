<?php

namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Blog\Entity\Comment;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;


class IndexController extends AbstractActionController
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

    public function indexAction()
    {
        $query = $this->entityManager->createQueryBuilder();

        $query
            ->add('select', 'a')
            ->add('from', 'Blog\Entity\Article a')
            ->add('where', 'a.isPublic=1')
            ->add('orderBy', 'a.id ASC');
        $adapter = new DoctrineAdapter(new ORMPaginator($query));

        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(1);
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));

        return array('articles'=>$paginator);

    }

    public function articleAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $article = $this->entityManager->find('Blog\Entity\Article', $id);

        if(empty($article)){
            return $this->notFoundAction();

        }

        $comment = new Comment();
        $form= $this->getCommentForm($comment);
        return ['article' => $article, 'form' => $form];
    }

    protected function getCommentForm(Comment $comment)
    {
        $builder = new AnnotationBuilder($this->entityManager);
        $form = $builder->createForm(new Comment());
        $form->setHydrator(new DoctrineHydrator($this->entityManager,'\Comment'));
        $form->bind($comment);

        return $form;
    }

    public function commentAddAction()
    {
        $comment = new Comment();

        $form = $this->getCommentForm($comment);
        $request = $this->getRequest();
        $response = $this->getResponse();

        $data = $request->getPost();

        if(! empty($data))
        {
            $form->setData($data);
            $message = null;

            if(! $form->isValid())
            {
                $errors = $form->getMessages();
                foreach ($errors as $key=>$row)
                {
                    if( ! empty($row) && $key != 'submit') {
                        foreach($row as $keyer => $rower) {
                            $messages[$key][] = $rower;
                        }
                    }
                }
            }

            if(! empty($messages)){
                $response->setContent(\Zend\Json\Json::encode($messages));
            } else {
                $this->entityManager->persist($comment);
                $this->entityManager->flush();
                $response->setContent(\Zend\Json\Json::encode(['success'=>1]));
            }
        }
        return $response;
    }

}
