<?php

$injector = new \Auryn\Injector;

/**
* HTTP
*/

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

/**
* Templating
*/

$injector->define('Mustache_Engine', [
	':options'=> [
		'loader'=> new Mustache_Loader_FilesystemLoader(dirname(__DIR__) . '/templates', [
			'extension' => '.html',]),
		],
	]);

$injector->delegate('Twig_Environment', function() use ($injector) {
	$loader = new Twig_Loader_Filesystem(dirname(__DIR__) . '/templates');
	$twig = new Twig_Environment($loader);
	return $twig;
});

$injector->alias('Noframework\Template\Renderer', 'Noframework\Template\TwigRenderer');

$injector->alias('Noframework\Template\FrontendRenderer', 'Noframework\Template\FrontendTwigRenderer');

/**
* Accessing page data
*/

$injector->define('Noframework\Page\FilePageReader', [
	':pageFolder'=> __DIR__ . '/../pages',
	]);

$injector->alias('Noframework\Page\PageReader', 'Noframework\Page\FilePageReader');
$injector->share('Noframework\Page\FilePageReader');



return $injector;

