<?php

namespace Shop\Form;

use Zend\Form\Form;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Zend\InputFilter\InputFilter;
use Doctrine\Common\Persistence\ObjectManager;



class SortForm extends Form implements ObjectManagerAwareInterface
{
    /**
     * Scenario ('create' or 'update').
     * @var string
     */
    private $scenario;

    protected $objectManager;

    public function setObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }
    public function getObjectManager()
    {
        return $this->objectManager;
    }
    public function __construct($scenario = 'filter', ObjectManager $objectManager)
    {
        parent::__construct('sort-form');
        $this->scenario = $scenario;
        $this->setObjectManager($objectManager);
        $this->setAttribute('method', 'post');

        $this->addElements();

        //$this->addInputFilter();
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
        /*if($this->scenario == 'filter') {
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
        }*/
        if($this->scenario == 'create')
        {
            $this->add([
                'type' => 'Number',
                'name' => 'quantity',
                'options' => [
                    'label' => 'Quantity',
                ],
                'attributes' => [
                    'id' => 'quantity',
                    'min' => '0',
                    'max' => '10',
                    'step' => '1', // default step interval is 1
                ],
            ]);

        }
        $this->add([
            'type' => 'DateTime',
            'name' => 'start',
            'attributes' => [
                'id' => 'start',
                'min' => $curdate . ' ' . $date,
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
                'min' => $curdate . ' ' . $date,
            ],
            'options' => [
                'label' => 'End Date',
                'format' => 'd.m.Y H:i'
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

}