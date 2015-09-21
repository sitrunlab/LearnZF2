<?php

$I = new AcceptanceTester($scenario);
$I->wantTo('get captcha demo page');
$I->amOnPage('/learn-zf2-ajax-image-gallery');
$I->see('Ajax Image upload example with Zend Framework 2');
