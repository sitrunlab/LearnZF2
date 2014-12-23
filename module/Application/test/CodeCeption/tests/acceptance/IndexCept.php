<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('get home page');
$I->amOnPage('/');
$I->see('Welcome to LearnZF2 site');
