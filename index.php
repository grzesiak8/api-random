<?php

use RestApi\Server;
use RestApi\Operations\Generate;
use RestApi\Operations\Retrive;

include 'vendor/autoload.php';

$rs = new Server();
$rs->checkAuthorization();
$rs->addOperartion('/generate', Generate::class);
$rs->addOperartion('/retrive?id=', Retrive::class, ['id' => '/^id=\d+$/']);
$rs->handleRequest();
$rs->sendResponse();