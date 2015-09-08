<?php

use \GPSOAuthPHP\GPSOAuthPHP;

define('ANDROID_ID', '0123456789abcdef');
define('SERVICE', 'sj');
define('APP', 'com.google.android.music');
define('CLIENT_SIG', '38918a453d07199354f8b19af05ec6562ced5788');

class GPSOAuthPHPTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->user = getenv('USER');
        $this->pass = getenv('PASS');
        $this->proxy = getenv('PROXY') ? getenv('PROXY') : '';
    }

    public function testPerformMasterLogin_withInvalidCredentials()
    {
        $expected = array('Error' => 'BadAuthentication');

        $gpsoauth = new GPSOAuthPHP($this->proxy);
        $actual = $gpsoauth->performMasterLogin('invalid_user', 'invalid_pass', ANDROID_ID);

        $this->assertEquals($expected, $actual);
    }

    public function testPerformOauth_withInvalidCredentials()
    {
        $expected = array('Error' => 'BadAuthentication');

        $gpsoauth = new GPSOAuthPHP($this->proxy);
        $actual = $gpsoauth->performOauth('invalid_user', 'invalid_token', ANDROID_ID, SERVICE, APP, CLIENT_SIG);

        $this->assertEquals($expected, $actual);
    }

    public function testPerformMasterLogin_withValidCredentials()
    {
        if (!$this->user || !$this->pass) {
            $this->markTestSkipped('You did not provide the Username or Password!');
        }

        $gpsoauth = new GPSOAuthPHP($this->proxy);
        $actual = $gpsoauth->performMasterLogin($this->user, $this->pass, ANDROID_ID);

        $this->assertTrue(is_array($actual));
        $this->assertTrue(array_key_exists('SID', $actual), 'Response contains SID');
        $this->assertTrue(array_key_exists('LSID', $actual), 'Response contains LSID');
        $this->assertTrue(array_key_exists('Auth', $actual), 'Response contains Auth');
        $this->assertTrue(array_key_exists('services', $actual), 'Response contains services');
        $this->assertTrue(array_key_exists('Email', $actual), 'Response contains Email');
        $this->assertTrue(array_key_exists('Token', $actual), 'Response contains Token');
        $this->assertTrue(array_key_exists('GooglePlusUpgrade', $actual), 'Response contains GooglePlusUpgrade');
        $this->assertTrue(array_key_exists('firstName', $actual), 'Response contains firstName');
        $this->assertTrue(array_key_exists('lastName', $actual), 'Response contains lastName');
    }
}