<?php

namespace Moip;

class Debug {

    private $file;

	public function __construct($file = 'moip.log') {
        $this->file = fopen(DIR_LOGS . $file, 'w+');
	}
    
    public function addError($message) {
        fwrite($this->file, print_r(array('Error' => $message), true));
    }
    
    public function addInfo($message) {
        fwrite($this->file, print_r(array('Info' => $message), true));
    }
    
    public function addText($key, $message) {
        fwrite($this->file, print_r(array($key => $message), true));
    }

	public function __destroy($file = 'moip.log') {
        fclose($this->file);
	}
    
}