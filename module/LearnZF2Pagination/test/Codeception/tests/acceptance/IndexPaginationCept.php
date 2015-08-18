<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('get pagination page');
$I->amOnPage('/learn-zf2-pagination');
$I->see('Pagination example with Zend Framework 2');
$I->dontSee("No elements found with provided conditions");
$I->fillField("keyword", "xyzxyzxyz"); // fill non exist data
$I->click(".btn-primary");
$I->see("No elements found with provided conditions");
$I->fillField("keyword", "a"); // data exists
$I->click(".btn-primary");
$I->seeElement('.pagination');
