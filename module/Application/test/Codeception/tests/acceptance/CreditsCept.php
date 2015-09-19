<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('get credits page');
$I->amOnPage('/credits');
$I->see('This site contained some grabbed outside resources');
$I->dontSee('Welcome to LearnZF2 site');
