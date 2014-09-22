<?php

namespace LearnZF2FormUsage\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class LearnZF2Form extends Form implements InputFilterProviderInterface
{
   public function __construct()
   {

   }
   
   public function init()
   {

   }

   public function getInputFilterSpecification()
   {
       return array();
   }
}

