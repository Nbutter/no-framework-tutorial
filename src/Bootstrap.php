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

$routeDefinitionCallback = function(\FastRoute\RouteCollector $r){
	$routes = include('Routes.php');
	foreach($routes as $route) {
		$r->addRoute($route[0], $route[1], $route[2]);
	}
};

$dispatcher = \FastRoute\simpleDispatcher($routeDefinitionCallback);

$routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPath());

switch ($routeInfo[0]) {
	case \FastRoute\Dispatcher::NOT_FOUND:
		$response->setContent('404 - page not found. Sorry!');
		$response->setStatusCode(404);
		break;
	case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
		$response->setContent('405 - method not allowed. Sorry!');
		$response->setStatusCode(405);
		break;
	case \FastRoute\Dispatcher::FOUND:
		$handler = $routeInfo[1];
		$vars = $routeInfo[2];
		call_user_func($handler, $vars);
		break;
}