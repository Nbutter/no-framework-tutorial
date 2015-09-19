<?php

namespace Noframework\Controllers;

class Page
{
	public function show($params){
		$slug = $params['slug'];
		$data['content'] = $this->pageReader->readBySlug($slug);
		$html = $this->renderer->render('Page', $data);
		$this->response->setContent($html);
		echo $this->response->getContent(); // not in tutorial (!)
	}
}