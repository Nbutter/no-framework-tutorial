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

$injector = include('Dependencies.php'); //uses Auryn injector

$request = $injector->make('Http\HttpRequest');
$response = $injector->make('Http\HttpResponse');

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
		$className = $routeInfo[1][0];
		$method = $routeInfo[1][1];
		$vars = $routeInfo[2];
		$class = $injector->make($className);
		$class->$method($vars);
		break;
}