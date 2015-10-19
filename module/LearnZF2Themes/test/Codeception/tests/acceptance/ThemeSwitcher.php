<?php

$I = new AcceptanceTester($scenario);
$I->amOnPage('/learn-zf2-themes');
$I->see('Themes switcher example with Zend Framework 2');
