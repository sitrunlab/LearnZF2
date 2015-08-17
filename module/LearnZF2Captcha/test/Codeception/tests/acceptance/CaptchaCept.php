<?php

$I = new AcceptanceTester($scenario);
$I->wantTo('get acl demo page');
$I->amOnPage('/learn-zf2-captcha');
$I->see('Form with Captcha in ZF2 demo');
