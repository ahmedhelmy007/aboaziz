<?php

namespace Series\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class SeriesForm extends Form {

    public function __construct($name = null, $options = array()) {
        parent::__construct('series');

        $this->setAttribute('method', 'post');
        $this->setInputFilter(new SeriesFilter());
        $this->setHydrator(new ClassMethods());

        $this->add(array(
            'name' => 'id',
            'type' => 'hidden',
        ));

        $this->add(array(
            'name' => 'title',
            'type' => 'text',
            'options' => array(
                'label' => 'Title',
            ),
            'attributes' => array(
                'id' => 'title',
                'maxlength' => 100,
            )
        ));

        $this->add(array(
            'name' => 'status',
            'type' => 'checkbox',
            'options' => array(
                'label' => 'status?',
                'label_attributes' => array('class' => 'checkbox'),
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Go',
                'class' => 'btn btn-primary',
            ),
        ));
    }

}
