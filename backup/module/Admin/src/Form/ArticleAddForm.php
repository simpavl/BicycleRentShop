<?php

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Blog\Entity\Article;


class ArticleAddForm extends Form implements ObjectManagerAwareInterface
{

    protected $objectManager;

    public function setObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }
    public function getObjectManager()
    {
        return $this->objectManager;
    }
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('articleAddForm');
        $this->setObjectManager($objectManager);
        $this->createElements();
    }

    public function createElements()
    {
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'bs-example form-horizontal');

        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'category',
            'options' => [
                'label' => 'Категории',
                'empty_option' => 'Выберите категорию...',
                'object_manager' => $this->getObjectManager(),
                'target_class' => 'Blog\Entity\Category',
                'property' => 'categoryName',
            ],
            'attributes' => [
                'class' => 'form-control',
                'required' => 'required',
            ],
        ]);

        $this->add([
            'name' => 'title',
            'type' => 'Text',
            'options' => [
                'min' => 3,
                'max' => 100,
                'label' => 'Заголовок',
            ],
            'attributes' => [
                'class' => 'form-control',
                'required' => 'required',
            ],
        ]);
        $this->add([
            'name' => 'shortArticle',
            'type' => 'Textarea',
            'options' => [
                'label' => 'Начало статьи',
            ],
            'attributes' => [
                'class' => 'form-control ckeditor',
            ],
        ]);
        $this->add([
            'name' => 'article',
            'type' => 'Textarea',
            'options' => [
                'label' => 'Статья',
            ],
            'attributes' => [
                'class' => 'form-control ckeditor',
                'required' => 'required',
            ],
        ]);
        $this->add([
            'name' => 'isPublic',
            'type' => 'Checkbox',
            'options' => [
                'label' => 'Опубликовать',
                'use_hidden_Element' => true,
                'checked_value' => 1,
                'unchecked_value' => 0
            ]
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => [
                'value' => 'Сохранить',
                'id' => 'btn_submit',
                'class' => 'btn btn-primary'
            ],
        ]);
    }
}