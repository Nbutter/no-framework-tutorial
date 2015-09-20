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

$injector->define('Mustache_Engine', [
	':options'=> [
		'loader'=> new Mustache_Loader_FilesystemLoader(dirname(__DIR__) . '/templates', [
			'extension' => '.html',]),
		],
	]);

$injector->define('Noframework\Page\FilePageReader', [
	':pageFolder'=> __DIR__ . '/../pages',
	]);

$injector->alias('Noframework\Page\PageReader', 'Noframework\Page\FilePageReader');
$injector->share('Noframework\Page\FilePageReader');

return $injector;

