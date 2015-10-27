<?php

namespace Moip;

class Response {

    private $response;

	public function __construct($response) {
        $this->response = $response;
	}
    
    public function getArray() {
        return json_decode($this->response, true);
    }
    
    public function getObject() {
        return json_decode($this->response);
    }
    
    public function getJson() {
        return $this->response;
    }
}