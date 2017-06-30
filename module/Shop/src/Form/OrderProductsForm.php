<?php

namespace Shop\Form;

use Doctrine\Common\Persistence\ObjectManager;
use Zend\Form\Form;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilter;

class OrderProductsForm extends Form
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
        parent::__construct('orderproducts-form');
        $this->setObjectManager($objectManager);
        $this->setAttribute('method', 'post');
        $this->addElements();
        $this->addInputFilter();
    }

    protected function addElements()
    {
        $curdate = date('d.m.Y');
        $hour = date('H');
        $minute = date('i');
        if (date('i') > 30) {
            $minute = '00';
            $date = new \DateTime($hour . ':' . $minute);
            $date->add(new \DateInterval('PT1H'));
        } else {
            $minute = '30';
            $date = new \DateTime($hour . ':' . $minute);
        }
        $date = $date->format('H:i');

        // Add "email" field
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'product',
            'options' => [
                'label' => 'Велосипеды',
                'empty_option' => 'Выберите велосипед...',
                'object_manager' => $this->getObjectManager(),
                'target_class' => 'Shop\Entity\Product',
                'property' => 'name',
            ],
            'attributes' => [
                'class' => 'form-control',
                'required' => 'required',
            ],
        ]);

        $this->add([
            'type' => 'Number',
            'name' => 'quantity',
            'options' => [
                'label' => 'Quantity',
            ],
            'attributes' => [
                'id' => 'Quantity',
            ],
        ]);

        $this->add([
            'type'  => 'select',
            'name' => 'status',
            'options' => [
                'label' => 'Status',
                'value_options' => [
                    1 => 'Waiting',
                    2 => 'Active',
                    3 => 'Inactive'
                ]
            ],
        ]);

        $this->add([
            'type' => 'DateTime',
            'name' => 'start',
            'attributes' => [
                'id' => 'start',
            ],
            'options' => [
                'label' => 'Start Date',
                'format' => 'd.m.Y H:i'
            ],
        ]);
        $this->add([
            'type' => 'DateTime',
            'name' => 'end',
            'attributes' => [
                'id' => 'end',
            ],
            'options' => [
                'label' => 'End Date',
                'format' => 'd.m.Y H:i'
            ],
        ]);
        // Add the Submit button
        $this->add([
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Create'
            ],
        ]);

    }

    /**
     * This method creates input filter (used for form filtering/validation).
     */
    private function addInputFilter()
    {
        // Create main input filter
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        // Add input for "status" field
        $inputFilter->add([
            'name'     => 'status',
            'required' => true,
            'filters'  => [
                ['name' => 'ToInt'],
            ],
            'validators' => [
                ['name'=>'InArray', 'options'=>['haystack'=>[1, 2, 3]]]
            ],
        ]);

    }
}