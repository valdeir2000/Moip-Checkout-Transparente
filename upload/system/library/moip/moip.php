<?php

namespace Moip;

use Moip\Order;
use Moip\Customer;
use Moip\Debug;

class Moip {
    
    private $token;
    private $key;
    private $sandbox;
    private $debug;
    
    public function __construct($token, $key, $sandbox = false, $debug = false) {
        $this->token = $token;
        $this->key = $key;
        $this->sandbox = $sandbox;
        $this->debug = $debug;
    }
    
    public function Order() {
        return new Order($this);
    }
    
    public function Customer() {
        return new Customer($this);
    }
    
    public function getToken() {
        return $this->token;
    }
    
    public function setModeSanbox($mode) {
        $this->sandbox = $mode;
    }
    
    public function getKey() {
        return $this->key;
    }
    
    public function isSandbox() {
        return ($this->sandbox) ? true : false;
    }
    
    public function setDebug($debug) {
        $this->debug = $debug;
    }
    
    public function getDebug() {
        return $this->debug;
    }
    
}