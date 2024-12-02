<?php

// JSON Format Converter Function
	  function error($content) {
	    return json_encode(['message' => $content]);
		
	  }

	  function success($content) {
	    return json_encode(['data' => $content]);
	  }

	  function retrieve($content) {
	    return json_encode(['data' => $content]);
	  }

	  function notfound($content) {
	    return json_encode(['data' => $content]);
	  }