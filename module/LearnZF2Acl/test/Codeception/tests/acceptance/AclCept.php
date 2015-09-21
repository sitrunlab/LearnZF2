<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('get acl demo page');
$I->amOnPage('/learn-zf2-acl');
$I->see('Zend\Permissions\Acl demo');
