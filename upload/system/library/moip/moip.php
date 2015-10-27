<?php

namespace Moip;

use Moip\Order;
use Moip\Customer;
use Moip\Debug;

class Moip {
    
    private $token;
    private $key;
    private $test;
    private $debug;
    
    public function __construct($token, $key, $test = false) {
        $this->token = $token;
        $this->key = $key;
        $this->test = $test;
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
    
    public function getKey() {
        return $this->key;
    }
    
    public function getTest() {
        return $this->test;
    }
    
    public function setModeTest($mode) {
        $this->test = $mode;
    }
    
    public function getModeTest() {
        return $this->test;
    }
    
    public function setDebug($debug) {
        $this->debug = $debug;
    }
    
    public function getDebug() {
        return $this->debug;
    }
    
}