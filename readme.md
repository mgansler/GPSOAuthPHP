# GPSOAuthPHP Library

Port of [simon-weber/gpsoauth](https://github.com/simon-weber/gpsoauth) **WIP**

For testing:

```PHP
<?php

require_once 'GPSOAuthPHP/GPSOAuthPHP.php';

$client = new GPSOAuthPHP\GPSOAuthPHP();

$data = $client->performMasterLogin('email@gmail.com', 'secret_password', '0123456789abcdef');

var_dump($data);