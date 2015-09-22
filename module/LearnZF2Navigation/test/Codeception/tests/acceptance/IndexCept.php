<?php

$I = new AcceptanceTester($scenario);
$I->wantTo('Get the navigation start age');
$I->amOnPage('/learn-zf2-navigation');
$I->see('Navigation example with Zend Framework 2');
$I->click('.dropdown-menu > li > a');
$I->see('Ajax example with Zend Framework 2');
