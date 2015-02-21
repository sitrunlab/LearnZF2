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
$I->see("&lt;priority&gt;0&lt;/priority&gt;&lt;priorityName&gt;EMERG&lt;/priorityName&gt;&lt;message&gt;xyzxyzxyz&lt;/message&gt;&lt;");
