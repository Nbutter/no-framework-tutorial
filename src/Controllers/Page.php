<?php

namespace Noframework\Controllers;

use Http\Response;
use Noframework\Template\Renderer;
use Noframework\Page\PageReader;
use Noframework\Page\InvalidPageException;

class Page
{
	private $response;
	private $renderer;
	private $pageReader;

	public function __construct(Response $response, Renderer $renderer, PageReader $pageReader) {
		$this->response = $response;
		$this->renderer = $renderer;
		$this->pageReader = $pageReader;
	}

	public function readBySlug($slug){
		if (!is_string($slug)) {
			throw new InvalidArgumentException('slug must be a string');
		}
	}

	public function show($params){
		
		$slug = $params['slug'];


		try {
			$data['content'] = $this->pageReader->readBySlug($slug);	
		} catch (InvalidPageException $e) {
			$this->response->setStatusCode(404);
			return $this->response->setContent('404 - Page not found');
		}
		
		$html = $this->renderer->render('Page', $data);
		$this->response->setContent($html);
		echo $this->response->getContent(); // not in tutorial (!)
	}
}