<?php

namespace Shop\Form;

use Zend\Form\Form;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilter;

class UserManageForm extends Form
{

    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager = null;

    /**
     * Current user.
     * @var Shop\Entity\User
     */
    private $user = null;

    public function __construct($entityManager = null, $user = null)
    {
        parent::__construct('user-form');

        $this->setAttribute('method', 'post');

        $this->entityManager = $entityManager;
        $this->user = $user;

        $this->addElements();
        $this->addInputFilter();
    }

    protected function addElements()
    {

        // Add "first_name" field
        $this->add([
            'type'  => 'text',
            'name' => 'first_name',
            'options' => [
                'label' => 'First Name',
            ],
        ]);

        $this->add([
            'type'  => 'text',
            'name' => 'last_name',
            'options' => [
                'label' => 'Last Name',
            ],
        ]);


        $this->add([
            'type'  => 'select',
            'name' => 'gender',
            'options' => [
                'label' => 'Gender',
                'value_options' => [
                    1 => 'Male',
                    2 => 'Female',
                ]
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

        // Add input for "email" field

        // Add input for "first_name" field
        $inputFilter->add([
            'name'     => 'first_name',
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 512
                    ],
                ],
            ],
        ]);

        // Add input for "last_name" field
        $inputFilter->add([
            'name'     => 'last_name',
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 512
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name'     => 'gender',
            'required' => true,
            'filters'  => [
                ['name' => 'ToInt'],
            ],
            'validators' => [
                ['name'=>'InArray', 'options'=>['haystack'=>[1, 2]]]
            ],
        ]);
    }
}