<?php

namespace Moip;

class Customer {
    
    private $ownId;
    private $fullname;
    private $email;
    private $birthDate;
    private $taxDocument = array();
    private $phone;
    private $street;
    private $streetNumber;
    private $complement;
    private $district;
    private $city;
    private $state;
    private $country;
    private $zipCode;
    
    public function setOwnId($ownId) {
        $this->ownId = $ownId;
        
        return $this;
    }
    
    public function getOwnId() {
        return $this->ownId;
    }
    
    public function setFullname($fullname) {
        if (preg_match('# #', $fullname)) {
            $this->fullname = $fullname;
        } else {
            throw new \Exception('Nome inválido');
        }
        
        return $this;
    }
    
    public function getFullname() {
        return $this->fullname;
    }
    
    public function setEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
        } else {
            throw new \Exception('E-mail inválido');
        }
        
        return $this;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function setBirthDate($birthDate) {
        $this->birthDate = date('Y-m-d', strtotime($birthDate));
        
        return $this;
    }
    
    public function getBirthDate() {
        return $this->birthDate;
    }
    
    public function setTaxDocument($value) {
        $this->taxDocument = array(
            'type' => 'CPF',
            'number' => $value
        );
        
        return $this;
    }
    
    public function getTaxDocument() {
        return $this->taxDocument;
    }
    
    public function setPhone($phone) {
        $this->phone = $phone;
        
        return $this;
    }
    
    public function getPhone() {
        return $this->phone;
    }
    
    public function setStreet($street) {
        $this->street = $street;
        
        return $this;
    }
    
    public function getStreet() {
        return $this->street;
    }
    
    public function setStreetNumber($streetNumber) {
        $this->streetNumber = (int)$streetNumber;
        
        return $this;
    }
    
    public function getStreetNumber() {
        return $this->streetNumber;
    }
    
    public function setComplement($complement) {
        $this->complement = $complement;
        
        return $this;
    }
    
    public function getComplement() {
        return !(empty($this->complement)) ? $this->complement : 'Desconhecido';
    }
    
    public function setDistrict($district) {
        $this->district = $district;
        
        return $this;
    }
    
    public function getDistrict() {
        return $this->district;
    }
    
    public function setCity($city) {
        $this->city = $city;
        
        return $this;
    }
    
    public function getCity() {
        return $this->city;
    }
    
    public function setState($state) {
        if (strlen($state) == 2) {
            $this->state = $state;
        } else {
            throw new \Exception('Estado inválido! Ex: BA');
        }
        
        return $this;
    }
    
    public function getState() {
        return $this->state;
    }
    
    public function setCountry($country) {
        if (strlen($country) == 3) {
            $this->country = $country;
        } else {
            throw new \Exception('País inválido! Ex: BRA');
        }
        
        return $this;
    }
    
    public function getCountry() {
        return $this->country;
    }
    
    public function setZipCode($zipCode) {
        $this->zipCode = preg_replace('/[^\d]/', '', $zipCode);
        
        return $this;
    }
    
    public function getZipCode() {
        return $this->zipCode;
    }

    public function getJson() {
        return array (
          'ownId' => $this->getOwnId(),
          'fullname' => $this->getFullname(),
          'email' => $this->getEmail(),
          'birthDate' => $this->getBirthDate(),
          'taxDocument' => $this->getTaxDocument(),
          'phone' => 
            array (
                'countryCode' => '55',
                'areaCode' => substr($this->getPhone(), 0, 2),
                'number' => substr($this->getPhone(), 2),
            ),
            'shippingAddress' => 
            array (
                'city' => $this->getCity(),
                'complement' => $this->getComplement(),
                'district' => $this->getDistrict(),
                'street' => $this->getStreet(),
                'streetNumber' => $this->getStreetNumber(),
                'zipCode' => $this->getZipCode(),
                'state' => $this->getState(),
                'country' => $this->getCountry()
            )
        );
    }
}