# GPSOAuthPHP Library [![build status](https://gitlab.martingansler.de/ci/projects/1/status.png?ref=master)](https://gitlab.martingansler.de/ci/projects/1?ref=master)

Port of [simon-weber/gpsoauth](https://github.com/simon-weber/gpsoauth) **WIP**

## Installation

Put in your `composer.json`:

```JSON
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/mgansler/GPSOAuthPHP"
        }
    ],
    "require": {
        "mgansler/GPSOAuthPHP": "dev-master"
    }
}
```

## Usage Example

```PHP
<?php

$email = 'your.email@gmail.com';
$passwd = 'secret_passwd';
$android_id = '0123456789abcdef';
$service = 'sj'; // example, take a look at $gpsoauth->performMasterLogin()
$app = 'com.google.android.music'; //example
$client_sig = '38918a453d07199354f8b19af05ec6562ced5788'; // for com.google.android.music

$gpsoauth = new GPSOAuthPHP\GPSOAuthPHP([string $proxy = NULL]);

if($master_token = $gpsoauth->performMasterLogin(string $email, string $passwd, string $android_id)) {
    if($auth = $gpsoauth->performOAuth(string $email, $master_token, $android_id, string $service, string $app, $client_sig, [string $device_country='us', string $operatorCountry='us', string $lang='en', string $sdk_version=17])['Auth']) {
        // Do your stuff with Auth-Token
    }
}
```
