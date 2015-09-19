<?php

$injector = new \Auryn\Injector;

$injector->alias('Http\Response', 'Http\HttpResponse');
$injector->share('Http\HttpRequest');
$injector->define('Http\HttpRequest', [
	':get'=> $_GET,
	':post'=> $_POST,
	':cookies'=> $_COOKIE,
	':files'=> $_FILES,
	':server'=> $_SERVER,
]);

$injector->alias('Http\Request', 'Http\HttpRequest');
$injector->share('Http\HttpResponse');

$injector->alias('Noframework\Template\Renderer', 'Noframework\Template\MustacheRenderer');

return $injector;

