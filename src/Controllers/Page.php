<?php

namespace Noframework\Controllers;

use Noframework\Page\InvalidPageException;
use Http\Response;
use Noframework\Template\FrontendRenderer;
use Noframework\Page\PageReader;

class Page
{
	private $response;
	private $renderer;
	private $pageReader;

	public function __construct(Response $response, FrontendRenderer $renderer, PageReader $pageReader) {
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
			//echo 'did you catch me?';
			$this->response->setStatusCode(404);
			$this->response->setContent('404 - Page not found');
			echo $this->response->getContent(); // not in tutorial
			return; // not in tutorial... needed this to exit 
		}
		
		//$data['content'] = $this->pageReader->readBySlug($slug);
		$html = $this->renderer->render('Page', $data);
		$this->response->setContent($html);
		echo $this->response->getContent(); // not in tutorial (!)
	}
}