<?php

return [
	['GET', '/hello-world', function(){
		echo 'Hello, world!';
	}],
	['GET', '/another-route', function(){
		echo "here's another route";
	}],
];