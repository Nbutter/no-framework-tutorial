<?php 

namespace Noframework\Controllers;

use Http\Request;
use Http\Response; 
use Noframework\Template\Renderer;

class Homepage
{
	private $request;
	private $response;
	private $renderer;

	public function __construct(Request $request, Response $response, Renderer $renderer) {
		$this->request = $request;
		$this->response = $response;
		$this->renderer = $renderer;
	}

	public function show() {
		
		$data = [ 
			'name' => $this->request->getParameter('name', 'stranger'),
			'menuItems' => [
				['href' => '/', 'text' => 'Homepage',], // adding a trailing comma
				['href' => 'http://www.google.com', 'text' => 'Google',],
			],
		];

		$html = $this->renderer->render('Homepage', $data);
		$this->response->setContent($html);

		// older way to show content
		//$content = '<h1>Hello, world!</h1>';
		//$content .= "Hello " . $this->request->getParameter('name', 'stranger');
		//$this->response->setContent($content);
		echo $this->response->getContent(); // missing in tutorial (!)
	}
}