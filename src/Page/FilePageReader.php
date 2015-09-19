<?php

namespace Noframework\Page;

use InvalidArgumentException;

class FilePageReader implements PageReader
{
	private $pageFolder;

	public function __construct($pageFolder){
		if (!is_string($pageFolder){
			throw new InvalidArgumentException('pageFolder must be a string');
		}
		$this->pageFolder = $pageFolder;
	}

	public function readBySlug($slug){
		return "this is a placeholder for reading by slug";
	}
}