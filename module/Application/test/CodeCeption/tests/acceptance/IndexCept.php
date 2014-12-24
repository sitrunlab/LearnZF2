<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('get home page');
$I->amOnPage('/');
$I->see('Welcome to LearnZF2 site');
$I->canSeeLink('Fork us on GitHub »');
$I->click('Fork us on GitHub »');
$I->executeInSelenium(function (\Webdriver $webdriver) {
    $handles = $webdriver->getWindowHandles();
    $last_window = end($handles);
    $webdriver->switchTo()->window($last_window);
});
$I->switchToWindow();
