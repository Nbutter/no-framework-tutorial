<?php

return [
	['GET', '/', ['Noframework\Controllers\Homepage', 'show']],
	['GET', '/{slug}', ['Noframework\Controllers\Page', 'show']],
];