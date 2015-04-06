<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('get log sample page');
$I->amOnPage('/learn-zf2-log');
$I->see('Zend\Log sample usage');
$I->dontSee("samsonasik@gmail.com");
$I->click(".btn-donate");
$I->see("samsonasik@gmail.com");
$I->fillField("logmessage", "xyzxyzxyz");
$I->selectOption('logformat', 'xml');
$I->selectOption('logpriority', 0);
$I->click(".btn-primary");
$I->see("<priority>0</priority><priorityName>EMERG</priorityName><message>xyzxyzxyz</message>");
