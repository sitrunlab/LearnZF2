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

        $this->add([
            'name' => 'username',
            'attributes' => [
                'type'  => 'text',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Username',
            ],
        ]);

        $this->add([
            'name' => 'password',
            'attributes' => [
                'type'  => 'password',
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Password',
            ],
        ]);

    }

} 