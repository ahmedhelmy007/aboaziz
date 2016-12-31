<?php

// Filename: /module/Sermon/src/Sermon/Form/SermonFieldset.php

namespace Sermon\Form;

use Sermon\Model\Sermon;
use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\ClassMethods;
 
class SermonFieldset extends Fieldset {

    public function __construct($name = null, $options = array()) {
        //When overwriting a __construct() method within the Zend\Form-component, be sure to always call:
        parent::__construct($name, $options);
        
        //telling fieldset to hydrate its data into an Sermon-object. However, the form itself doesn’t know that it 
        //has to return an object
        $this->setHydrator(new ClassMethods(false));
        $this->setObject(new Sermon());
        
        $this->add(array(
            'type' => 'hidden',
            'name' => 'id'
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'description',
            'options' => array(
                'label' => 'The description'
            )
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'title',
            'options' => array(
                'label' => 'Sermon Title'
            )
        ));
    }

}
