<?php

// Filename: /module/Sermon/src/Sermon/Form/SermonForm.php

namespace Sermon\Form;

use Zend\Form\Form;

class SermonForm extends Form {

    public function __construct($name = null, $options = array()) {
        //When overwriting a __construct() method within the Zend\Form-component, be sure to always call:
        parent::__construct($name, $options);
        
        $this->add(array(
            'name' => 'sermon-fieldset',
            'type' => 'Sermon\Form\SermonFieldset',
            'options' => array(
                //the form itself doesn’t know that it has to return a Sermon object. When the form doesn’t know that 
                //it’s supposed to return an object it uses the ArraySeriazable hydrator recursively. To change this, 
                //all we need to do is to make our PostFieldset a so-called base_fieldset. A base_fieldset basically 
                //tells the form “this form is all about me, don’t worry about other data. And when the form knows that
                // this fieldset is the real deal, then the form will use the hydrator presented by the fieldset and 
                // return the object that we desire
                'use_as_base_fieldset' => true
            )
        ));

        $this->add(array(
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => array(
                'value' => 'Insert new Sermon'
            )
        ));
    }

}
