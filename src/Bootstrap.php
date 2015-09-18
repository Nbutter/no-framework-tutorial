<?php 

namespace Noframework;

require __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);

$environment = 'development';

/**
* Register the error handler
* 
*/

$whoops = new \Whoops\Run;
if ($environment !== 'production'){
	$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
} else {
	$whoops->pushHandler(function($e){
		echo 'Friendly error page and send an email';
	});
}

$whoops->register();

/**
* Uses patricklouys/http
* to follow tutorial more easily
*/

$request = new \Http\HttpRequest($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
$response = new \Http\HttpResponse;

foreach ($response->getHeaders() as $header) {
	header($header, false);  // ~ overwrite existing headers = false
}

$response->setContent('<h1>Test content, yo!</h1>');

echo $response->getContent();