<?php

namespace Shop\Form;

use Zend\Form\Form;

use Zend\InputFilter\InputFilter;




class OrderForm extends Form
{
    public function __construct()
    {
        parent::__construct('order-form');

        $this->setAttribute('method', 'post');

        $this->addElements();

    }

    protected function addElements()
    {
        $this->add([
            'type' => 'submit',
            'name' => 'order',
            'attributes' => [
                'value' => 'Orders',
                'id' => 'orderbutton',
            ],
        ]);
    }
}