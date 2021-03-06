<?php

namespace Shop\Form;

use Zend\Form\Form;

use Zend\InputFilter\InputFilter;




class CategoryForm extends Form
{
    public function __construct()
    {
        parent::__construct('category-form');

        $this->setAttribute('method', 'post');

        $this->addElements();

        $this->addInputFilter();
    }

    protected function addElements()
    {
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
    }
}