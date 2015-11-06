<?php

namespace Moip;

class Request {
    
    const ENDPOINT_PRODUCTION = 'https://api.moip.com.br';
    const ENDPOINT_SANDBOX = 'https://sandbox.moip.com.br';
    const VERSION = 'v2';
    
    private $moip;
    private $curl;
    private $data;
    private $path;
    private $url;
    private $headers = array();
    
    public function __construct($path, $data, Moip $moip) {
        $this->moip = $moip;
        $this->data = $data;
        $this->path = strtolower($path);
        $this->curl = curl_init();
        
        if ($moip->getModeTest()) {
            $this->url = self::ENDPOINT_SANDBOX;
        } else {
            $this->url = self::ENDPOINT_PRODUCTION;
        }
        
        $this->addHeader('Content-Type: application/json');
        $this->addHeader('Authorization: Basic ' . base64_encode($moip->getToken() . ':' . $moip->getKey()));
        
        return $this;
    }
    
    public function addHeader($header) {
        $this->headers[] = $header;
        
        return $this;
    }
    
    public function addCurlOpt($opt, $value) {
        curl_setopt($this->curl, $opt, $value);
        
        return $this;
    }
    
    public function execute() {        
        curl_setopt($this->curl, CURLOPT_URL, $this->url . '/' . self::VERSION . '/' . $this->path . '/');
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_POST, true);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->data);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($this->curl, CURLOPT_SSLVERSION, 1);
        
        $response = curl_exec($this->curl);
        $curl_error = curl_error($this->curl);
        $curl_info = curl_getinfo($this->curl);
        
        curl_close($this->curl);
        
        if ($this->moip->getDebug()) {
            $debug = new Debug();
            $debug->addText('URL', $this->url . '/' . self::VERSION . '/' . $this->path . '/');
            $debug->addText('Response', $response);
            $debug->addText('Data', $this->data);
            $debug->addText('Headers', $this->headers);
            $debug->addError($curl_error);
            $debug->addInfo($curl_info);
        }
        
        $result = json_decode($response, true);
        
        if ($response && !isset($result['error'])) {
            return new Response($response);
        } else {
            throw new \Exception('Moip Error :: Falha ao executar a requisição');
        }
    }
    
}