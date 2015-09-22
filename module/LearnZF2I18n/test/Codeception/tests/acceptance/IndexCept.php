<?php

$I = new AcceptanceTester($scenario);
$I->wantTo('Get the internationalization start page');
$I->amOnPage('/learn-zf2-i18n');
$I->see('I18n example with Zend Framework 2');
$I->see('Messages in current language (en_US)');

$I->amOnPage('/learn-zf2-i18n?lang=id_ID');
$I->see('Messages in current language (id_ID)');

$I->amOnPage('/learn-zf2-i18n?lang=es_ES');
$I->see('Messages in current language (es_ES)');

$I->amOnPage('/learn-zf2-i18n');
$I->submitForm('#changeLanguageForm', array('lang' => 'id_ID'));
$I->see('Messages in current language (id_ID)');
