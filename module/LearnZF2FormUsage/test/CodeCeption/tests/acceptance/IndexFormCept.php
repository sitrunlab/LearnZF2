<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('get learn form page');
$I->amOnPage('/learn-zf2-form-usage');
$I->see('Form with Zend\Form sample usage');
$I->dontSee("samsonasik@gmail.com");
$I->click(".btn-donate");
$I->see("samsonasik@gmail.com");
$I->dontSee("Value is required and can't be empty");
$I->click("#submitbutton");
$I->see("Value is required and can't be empty");
