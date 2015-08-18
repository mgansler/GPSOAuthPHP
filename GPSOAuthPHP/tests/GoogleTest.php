<?php

use \GPSOAuthPHP\Google;

class GoogleTest extends \PHPUnit_Framework_TestCase
{
    public function testSignature()
    {
        (new Google())->signature('invald_user', 'invalid_pass');
    }
}