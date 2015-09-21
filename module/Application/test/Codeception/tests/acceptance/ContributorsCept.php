<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('get contributors page');
$I->amOnPage('/contributors');
$I->see('Thanks to :');
$I->dontSee('Welcome to LearnZF2 site');
