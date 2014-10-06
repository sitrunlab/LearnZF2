<?php
/**
 * Created by PhpStorm.
 * User: mockie
 * Date: 9/28/14
 * Time: 5:10 PM
 */

namespace LearnZF2Ajax\Form;


use Zend\Form\Form;

class LoginForm extends Form  {

    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('login');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'username',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Username',
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type'  => 'password',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));

    }

} 