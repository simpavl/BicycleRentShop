<?php

namespace Shop\Form;

use Zend\Form\Form;

use Zend\InputFilter\InputFilter;




class CartForm extends Form
{
    public function __construct()
    {
        parent::__construct('cart-form');

        $this->setAttribute('method', 'post');

        $this->addElements();

    }

    protected function addElements()
    {
        $this->add([
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'hiddentoken',
            'attributes' => [
                'id' => 'hiddentoken'
            ],
        ]);
        $this->add([
            'type' => 'submit',
            'name' => 'update',
            'attributes' => [
                'value' => 'Update',
                'id' => 'submitbutton',
            ],
        ]);
        $this->add([
            'type' => 'submit',
            'name' => 'delete',
            'attributes' => [
                'value' => 'Delete',
                'id' => 'submitbutton',
            ],
        ]);
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