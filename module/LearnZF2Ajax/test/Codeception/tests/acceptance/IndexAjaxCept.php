<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('get Ajax page');
$I->amOnPage('/learn-zf2-ajax');
$I->see('ajax example with zend framework 2');
