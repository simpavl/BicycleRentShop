<?php

namespace Shop\Form;

use Zend\Form\Form;

use Zend\InputFilter\InputFilter;




class ProductImageForm extends Form
{
    public function __construct()
    {
        parent::__construct('productimage-form');

        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilter();
    }

    protected function addElements()
    {
        $this->add([
            'type' => 'File',
            'name' => 'image-file',
            'attributes' => [
                'id' => 'image-file',
                'multiple' => true
            ],
            'options' => [
                'label' => 'Upload images',
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