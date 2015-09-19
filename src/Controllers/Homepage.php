<?php 

namespace Noframework\Controllers;

use Http\Request;
use Http\Response; 

class Homepage
{
	private $request;
	private $response;

	public function __construct(Request $request, Response $response) {
		$this->request = $request;
		$this->response = $response;
	}

	public function show() {
		$content = '<h1>Hello, world!</h1>';
		$content .= "Hello " . $this->request->getParameter('name', 'stranger');
		$this->response->setContent($content);
		echo $this->response->getContent();
	}
}