<?php

namespace Shop\Form;

use Zend\Form\Form;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Zend\InputFilter\InputFilter;
use Doctrine\Common\Persistence\ObjectManager;




class ProductForm extends Form implements ObjectManagerAwareInterface
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
        parent::__construct('subcategory-form');
        $this->setObjectManager($objectManager);

        $this->setAttribute('method', 'post');

        $this->addElements();

        $this->addInputFilter();

    }

    protected function addElements()
    {
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'category',
            'options' => [
                'label' => 'Категории',
                'empty_option' => 'Выберите категорию...',
                'object_manager' => $this->getObjectManager(),
                'target_class' => 'Shop\Entity\Subcategory',
                'label_generator' => function ($targetEntity) {
                    return $targetEntity->getCategory()->getName() . ' - ' . $targetEntity->getName();
                },
            ],
            'attributes' => [
                'class' => 'form-control',
                'required' => 'required',
            ],
        ]);

        $this->add([
            'type' => 'text',
            'name' => 'name',
            'attributes' => [
                'id' => 'name'
            ],
            'options' => [
                'label' => 'Name',
            ],
        ]);
        $this->add([
            'type' => 'text',
            'name' => 'description',
            'attributes' => [
                'id' => 'description'
            ],
            'options' => [
                'label' => 'Description',
            ],
        ]);
        $this->add([
            'type' => 'number',
            'name' => 'price',
            'attributes' => [
                'id' => 'price'
            ],
            'options' => [
                'label' => 'Price',
            ],
        ]);
        $this->add([
            'type' => 'number',
            'name' => 'quantity',
            'attributes' => [
                'id' => 'quantity'
            ],
            'options' => [
                'label' => 'Quantity',
            ],
        ]);
        $this->add([
            'type' => 'File',
            'name' => 'image-file',
            'attributes' => [
                'id' => 'image-file',
            ],
            'options' => [
                'label' => 'Upload product logo',
            ],
        ]);
        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Create',
                'id' => 'submitbutton',
            ],
        ]);
    }
    protected function addInputFilter()
    {
        $inputfilter = new InputFilter();
        $this->setInputFilter($inputfilter);

        $inputfilter->add([
            'name' => 'name',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 100
                    ],
                ],
            ],
        ]);
        $inputfilter->add([
            'name' => 'description',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 255
                    ],
                ],
            ],
        ]);
        $inputfilter->add([
            'name' => 'image-file',
            'required' => true,
            'filters' => [
                ['name' => 'filerenameupload',
                    'options' => [
                        'target' => 'public/img/image.jpg',
                        'randomize' => true,
                    ]
                ],
            ],
        ]);

    }
}