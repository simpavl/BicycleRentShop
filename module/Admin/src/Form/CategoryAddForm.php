<?php
/**
 * Created by PhpStorm.
 * User: Павел
 * Date: 09.04.2017
 * Time: 22:15
 */
namespace Admin\Form;
use Zend\Form\Form;


class CategoryAddForm extends Form {
    public function __construct($name = null, array $options = [])
    {
        parent::__construct('CategoryAddForm');
        $this->setAttribute('method','post');
        $this->setAttribute('class','bs-example form-horizontal');

        $this->add([
            'name' => 'categoryKey',
            'type' => 'Text',
            'options' => [
                'min' => 3,
                'max' => 100,
                'label' => 'Ключ',
            ],
            'attributes' => [
                'class' => 'form-control',
                'required' => 'required',
            ],
        ]);

        $this->add([
            'name' => 'categoryName',
            'type' => 'Text',
            'options' => [
                'min' => 3,
                'max' => 100,
                'label' => 'Название',
            ],
            'attributes' => [
                'class' => 'form-control',
                'required' => 'required',
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => [
                'value' => 'Сохранить',
                'id' => 'btn_submit',
                'class' => 'btn btn-primary',
            ],
        ]);
    }
}