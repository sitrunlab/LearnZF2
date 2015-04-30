<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('get authentication demo page');
$I->amOnPage('/learn-zf2-authentication');
$I->see('Authentication example with Zend Framework 2');
