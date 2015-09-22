<?php

$I = new AcceptanceTester($scenario);
$I->wantTo('get barcode page');
$I->amOnPage('/learn-zf2-barcode');
$I->see('Barcode generation with Zend\Barcode sample usage');
