<?php

namespace Testmodule\Form;

use Zend\Form\Form;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilter;
use Zend\Hydrator\HydrationInterface;

class UserForm extends Form
{
    /**
     * Scenario ('create' or 'update').
     * @var string
     */
    private $scenario;

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
        // Add "email" field
        $this->add([
            'type'  => 'text',
            'name' => 'email',
            'options' => [
                'label' => 'E-mail',
            ],
        ]);

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
            // Add "password" field
        $this->add([
                'type'  => 'password',
                'name' => 'password',
                'options' => [
                    'label' => 'Password',
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
        $inputFilter->add([
            'name'     => 'email',
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 50
                    ],
                ],
                [
                    'name' => 'EmailAddress',
                    'options' => [
                        'allow' => \Zend\Validator\Hostname::ALLOW_DNS,
                        'useMxCheck'    => false,
                    ],
                ],
                /* [
                     'name' => UserExistsValidator::class,
                     'options' => [
                         'entityManager' => $this->entityManager,
                         'user' => $this->user
                     ],
                 ],*/
            ],
        ]);

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
            // Add input for "password" field
            $inputFilter->add([
                'name'     => 'password',
                'required' => true,
                'filters'  => [
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'min' => 6,
                            'max' => 64
                        ],
                    ],
                ],
            ]);

    }
}