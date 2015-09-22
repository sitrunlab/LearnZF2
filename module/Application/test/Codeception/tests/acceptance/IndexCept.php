<?php

$I = new AcceptanceTester($scenario);
$I->wantTo('get home page and click links');
$I->amOnPage('/');
$I->see('Welcome to LearnZF2 site');
$I->canSeeLink('Contributors');
$I->click('Contributors');
$I->see('Thanks to :');
$I->click('Home');
$I->click('.link-module a');
$I->see('Download module');
$I->click('Home');
$I->canSeeLink('Fork us on GitHub »');
$I->click('Fork us on GitHub »');
$I->executeInSelenium(function (\Webdriver $webdriver) {
    $handles = $webdriver->getWindowHandles();
    $last_window = end($handles);
    $webdriver->switchTo()->window($last_window);
});
