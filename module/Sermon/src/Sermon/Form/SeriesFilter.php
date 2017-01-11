<?php

namespace Series\Form;

use Zend\InputFilter\InputFilter;

/**
 * set up validation in Zend Framework is done using an input filter which can either be standalone or within any class
 * that implements InputFilterAwareInterface, such as a model entity. For this application we are going to create a 
 * separate class for our input filter.
 */
class SeriesFilter extends InputFilter {

    public function __construct() {
        $this->add(array(
            'name' => 'id',
            'required' => true,
            'filters' => array(
                array('name' => 'Int'),
            ),
        ));

        //The difference between filters and validators is that a filter changes the data passed through it and a 
        //validator tests if the data matches some specific criteria. For the title, we filter the string with 
        //StripTags and StringTrim and finally ensure that the string is no longer than 100 characters with the 
        //StringLength validator
        $this->add(array(
            'name' => 'title',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'max' => 100
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'status',
            'required' => false,
        ));
    }

}
