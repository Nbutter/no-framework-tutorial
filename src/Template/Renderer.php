<?php

namespace Noframework\Template;

interface Renderer
{
		public function render($template, $data = []);
}