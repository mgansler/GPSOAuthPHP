<?php

use \GPSOAuthPHP\GPSOAuthPHP;

define('ANDROID_ID', '0123456789abcdef');
define('SERVICE', 'sj');
define('APP', 'com.google.android.music');
define('CLIENT_SIG', '38918a453d07199354f8b19af05ec6562ced5788');

class GPSOAuthPHPTest extends \PHPUnit_Framework_TestCase
{
    public function testPerformMasterLogin()
    {
        $expected = array('Error' => 'BadAuthentication');

        $gpsoauth = new GPSOAuthPHP();
        $actual = $gpsoauth->performMasterLogin('invalid_user', 'invalid_pass', ANDROID_ID);

        $this->assertEquals($expected, $actual);
    }

    public function testPerformOauth()
    {
        $expected = array('Error' => 'BadAuthentication');

        $gpsoauth = new GPSOAuthPHP();
        $actual = $gpsoauth->performOauth('invalid_user', 'invalid_token', ANDROID_ID, SERVICE, APP, CLIENT_SIG);

        $this->assertEquals($expected, $actual);
    }
}