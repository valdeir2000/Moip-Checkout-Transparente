<?php

namespace Moip;

//use Receiver;
//use Request;
//use Response;

/**
    Class responsável pela criação, edição e busca de pedidos
    @author: Valdeir Santana <valdeir.naval@gmail.com>
*/
class Order {
    
    /**
        @var object Classe do MoIP
    */
    private $moip;
    
    /**
        @var string Identificação do pedido
    */
    private $ownId;
    
    /**
        @var string Moeda utilizada no pedido
    */
    private $currency = 'BRL';
    
    /**
        @var string Moedas permitidas
    */
    private $currencies_allow = array('BRL');
    
    /**
        @var int Valor de frete do item, será somado ao valor dos itens. Em centavos Ex: R$10,32 deve ser informado 1032
    */
    private $shipping;
    
    /**
        @var int Valor adicional ao item, será somado ao valor dos itens. Em centavos Ex: R$10,32 deve ser informado 1032
    */
    private $addition;
    
    /**
        @var int Valor de desconto do item, será subtraído do valor total dos itens. Em centavos Ex: R$10,32 deve ser informado 1032
    */
    private $discount;
    
    /**
        @var array Informações dos items do pedido
    */
    private $items = array();
    
    /**
        @var string|object Cliente do pedido. Pode ser informado o identificador(id) de um cliente já existente ou a coleção de dados para a criação de um novo ciliente.
    */
    private $customer;
    
    /**
        @var string URLs de redirecionamento.
    */
    private $redirectUrls;
    
    /**
        @var string URL para redirecionamento em casos de sucesso
    */
    private $urlSuccess;
    
    /**
        @var string URL para redirecionamento em casos de falha
    */
    private $urlError;
    
    /**
        @var array Configurações de parcelamento
    */
    private $installments = array();
    
    /**
        @var bool Configuração para que o pedido seja mantido em custódia.
    */
    private $holdInEscrow;
    
    /**
        @var bool Estrutura de recebedores dos pagamentos. Usado em Marketplaces.
    */
    private $receivers = array();
    
    public function __construct(Moip $class) {
        $this->moip = $class;
    }
    
    public function setOwnId($ownId) {
        $this->ownId = $ownId;
        
        return $this;
    }
    public function getOwnId() {
        return $this->ownId;
    }
    
    public function setCurrency($currency) {        
        if (in_array($currency, $this->currencies_allow)) {
            $this->currency = $currency;
        } else {
            throw new \Exception('MoIP Error :: Moeda não permitida');
        }
        
        return $this;
    }
    public function getCurrency() {
        if (in_array($currency, $this->currencies_allow)) {
            return $this->currency;
        } else {
            throw new \Exception('MoIP Error :: Moeda não permitida');
        }
    }
    
    public function setShipping($shipping) {
        $this->shipping = (int)$shipping;
        
        return $this;
    }
    public function getShipping() {
        return $this->shipping;
    }
    
    public function setAddition($addition) {
        $this->addition = (int)$addition;
        
        return $this;
    }
    public function getAddition() {
        return $this->addition;
    }
    
    public function setDiscount($discount) {
        $this->discount = (int)$discount;
        
        return $this;
    }
    public function getDiscount() {
        return $this->discount;
    }
    
    public function setItem($product, $price, $quantity = 1, $detail = '') {
        $item = new \StdClass;
        $item->product = $product;
        $item->price = (int)$price;
        $item->quantity = (int)$quantity;
        $item->detail = $detail;
        
        $this->items[] = $item;
        
        return $this;
    }
    public function getItems() {
        if (!empty($this->items)) {
            return (array)$this->items;
        } else {
            throw new \Exception('MoIP Error :: Produtos não adicionados');
        }
    }
    
    public function setCustomer($customer) {
        if ($customer instanceof Customer) {
            $this->customer = $customer;
        } else {
            throw new Exception('Cliente inválido');
        }
        
        return $this;
    }
    public function getCustomer() {
        if (!empty($this->customer)) {
            return array (
                  'ownId' => $this->customer->getOwnId(),
                  'fullname' => $this->customer->getFullname(),
                  'email' => $this->customer->getEmail(),
                  'birthDate' => $this->customer->getBirthDate(),
                  'taxDocument' => $this->customer->getTaxDocument(),
                  'phone' => 
                    array (
                        'countryCode' => '55',
                        'areaCode' => substr($this->customer->getPhone(), 0, 2),
                        'number' => substr($this->customer->getPhone(), 2),
                    ),
                    'shippingAddress' => 
                    array (
                        'city' => $this->customer->getCity(),
                        'complement' => $this->customer->getComplement(),
                        'district' => $this->customer->getDistrict(),
                        'street' => $this->customer->getStreet(),
                        'streetNumber' => $this->customer->getStreetNumber(),
                        'zipCode' => $this->customer->getZipCode(),
                        'state' => $this->customer->getState(),
                        'country' => $this->customer->getCountry()
                    )
                );
        } else {
            throw new \Exception('MoIP Error :: Cliente não identificado');
        }
    }
    
    public function setRedirectUrls($redirectUrls) {
        $this->redirectUrls = $redirectUrls;
        
        return $this;
    }
    public function getRedirectUrls() {
        return $this->redirectUrls;
    }
    
    public function setUrlSuccess($urlSuccess) {
        $this->urlSuccess = $urlSuccess;
        
        return $this;
    }
    public function getUrlSuccess() {
        return $this->urlSuccess;
    }
    
    public function setUrlError($urlError) {
        $this->urlError = $urlError;
        
        return $this;
    }
    public function getUrlError() {
        return $this->urlError;
    }
    
    public function setInstallments($min = 1, $max = 12, $discount = 0, $addition = 0) {
        $installment = new \StdClass;
        $installment->quantity = array((int)$min, (int)$max);
        $installment->discount = (int)$discount;
        $installment->addition = (int)$addition;
        
        $this->installments[] = $installment;
        
        return $this;
    }
    public function getInstallments() {
        if (!empty($this->installments)) {
            return $this->installments;
        } else {
            throw new \Exception('MoIP Error :: O preenchimento das parcelas é obrigatório');
        }
    }
    
    public function setHoldInEscrow($holdInEscrow) {
        $this->holdInEscrow = (bool)$holdInEscrow;
        
        return $this;
    }
    public function getHoldInEscrow() {
        return (bool)$this->holdInEscrow;
    }
    
    public function setReceivers(Receiver $receivers) {}
    public function getReceivers() {}
    
    public function create() {
        $data = array();
        
        $data['ownId'] = $this->ownId;
        
        $data['amount'] = array();
        
        $data['amount']['currency'] = $this->currency;
        
        $data['amount'] = array();
        
        if ($this->getShipping()) {
            $data['amount']['subtotals']['shipping'] = $this->shipping;
        }
        
        if ($this->getAddition()) {
            $data['amount']['subtotals']['addition'] = $this->addition;
        }
        
        if ($this->getDiscount()) {
            $data['amount']['subtotals']['discount'] = $this->discount;
        }
        
        $data['items'] = (array)$this->getItems();
        
        $data['customer'] = $this->getCustomer();
        
        if ($this->getRedirectUrls()) {
            $data['checkoutPreferences']['redirectUrls'] = $this->redirectUrls;
        }
        
        if ($this->getUrlSuccess()) {
            $data['checkoutPreferences']['urlSuccess'] = $this->urlSuccess;
        }
        
        if ($this->getUrlError()) {
            $data['checkoutPreferences']['urlError'] = $this->urlError;
        }
        
        $data['installments'] = $this->getInstallments();
        
        if ($this->getHoldInEscrow()) {
            $data['holdInEscrow'] = $this->holdInEscrow;
        }
        
        $request = new Request('Orders', json_encode($data), $this->moip);
        
        echo json_encode($data);
        
        return $request->execute();
    }
}





















