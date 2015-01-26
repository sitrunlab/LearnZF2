<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('get barcode page');
$I->amOnPage('/learn-zf2-barcode');
$I->see('Barcode generation with Zend\Barcode sample usage');
$I->dontSee("samsonasik@gmail.com");
$I->click(".btn-donate");
$I->see("samsonasik@gmail.com");
