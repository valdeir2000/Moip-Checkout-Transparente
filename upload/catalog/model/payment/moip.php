<?php
class ModelPaymentMoip extends Model {
	public function getMethod($address, $total) {
		return array();
	}
	
	public function captureToken($data = array()) {
		$Moip = new Moip\Moip(
            $this->config->get('moip_token'),
            $this->config->get('moip_key'),
            $this->config->get('moip_sandbox'),
            $this->config->get('moip_debug_status')
        );
        
        $MoipOrder = $Moip->Order();
        
        $MoipOrder->setOwnId('PSR-Order-' . $data['order_id']);
        $MoipOrder->setCurrency('BRL');
        
        if (isset($data['shipping_method'])) {
            $MoipOrder->setShipping($data['shipping_method']['cost']*100);
        }
        
        $MoipOrder->setAddition($this->calculateAddition($data['payment_code']));
        
        $MoipOrder->setDiscount($this->calculateDiscount($data['payment_code']));
        
        foreach($this->cart->getProducts() as $product) {
            $MoipOrder->setItem(
                $product['name'], 
                ($product['price']*100), 
                $product['quantity'], 
                $this->getProductDetails($product)
            );
        }
        
        $MoipCustomer = $Moip->Customer()
                             ->setOwnId('PSR-Customer-' . $data['customer_id'])
                             ->setFullname(implode(' ', array($data['firstname'], $data['lastname'])))
                             ->setEmail($data['email'])
                             ->setBirthDate($data['custom_field'][$this->config->get('moip_data_nascimento')])
                             ->setTaxDocument($data['custom_field'][$this->config->get('moip_cpf')])
                             ->setPhone($data['telephone'])
                             ->setStreet($data['payment_address_1'])
                             ->setStreetNumber($data['payment_custom_field'][$this->config->get('moip_endereco_numero')])
                             ->setComplement($data['payment_company'])
                             ->setDistrict($data['payment_address_2'])
                             ->setCity($data['payment_city'])
                             ->setState($data['payment_zone_code'])
                             ->setCountry($data['payment_iso_code_3'])
                             ->setZipCode($data['payment_postcode']);
        
        $MoipOrder->setCustomer($MoipCustomer);
        
        $MoipOrder->setUrlSuccess($this->url->link('payment/moip/success', '', true));
        $MoipOrder->setUrlError($this->url->link('payment/moip/error', '', true));
        
        foreach($this->config->get('moip_parcela') as $installment) {
            
            $discount = 0;
            $increase = 0;
            
            if ($installment['desconto_tipo'] = 'F') {
                $discount = $installment['desconto'];
            } elseif ($installment['desconto_tipo'] == 'P') {
                $discount = ($installment['desconto'] / 100) * $this->cart->getSubTotal();
            }
            
            if ($installment['acrescimo_tipo'] = 'F') {
                $increase = $installment['acrescimo'];
            } elseif ($installment['acrescimo_tipo'] == 'P') {
                $increase = ($installment['acrescimo'] / 100) * $this->cart->getSubTotal();
            }
            
            $MoipOrder->setInstallments($installment['de'], $installment['para'], $discount, $increase);
        }
        
        return $MoipOrder->create();
	}

	private function getProductDetails($product) {
        $details = '';
        
        foreach($product['option'] as $option) {
            $details .= $option['name'] . ': ' . $option['value'];
            
            if (end($product['option']) != $option) {
                $details .= ' / ';
            }
        }
        
        return $details;
    }
    
    private function calculateAddition($payment_code) {
        if ($payment_code == 'moip_boleto' && $this->config->get('moip_acrescimo_boleto')) {
            if ($this->config->get('moip_acrescimo_boleto_tipo') == 'P') {
                return (($this->config->get('moip_acrescimo_boleto')/100) * $this->cart->getSubTotal()) * 100;
            } else {
                return ($this->config->get('moip_acrescimo_boleto')*100);
            }
        }
        
        if ($payment_code == 'moip_cartao' && $this->config->get('moip_acrescimo_cartao')) {
            if ($this->config->get('moip_acrescimo_cartao_tipo') == 'P') {
                return (($this->config->get('moip_acrescimo_cartao')/100) * $this->cart->getSubTotal()) * 100;
            } else {
                return ($this->config->get('moip_acrescimo_cartao')*100);
            }
        }
        
        if ($payment_code == 'moip_debito' && $this->config->get('moip_acrescimo_debito')) {
            if ($this->config->get('moip_acrescimo_debito_tipo') == 'P') {
                return (($this->config->get('moip_acrescimo_debito')/100) * $this->cart->getSubTotal()) * 100;
            } else {
                return ($this->config->get('moip_acrescimo_debito')*100);
            }
        }
    }
    
    private function calculateDiscount($payment_code) {
        if ($payment_code == 'moip_boleto' && $this->config->get('moip_desconto_boleto')) {
            if ($this->config->get('moip_desconto_boleto_tipo') == 'P') {
                return (($this->config->get('moip_desconto_boleto')/100) * $this->cart->getSubTotal()) * 100;
            } else {
                return ($this->config->get('moip_desconto_boleto')*100);
            }
        }
        
        if ($payment_code == 'moip_cartao' && $this->config->get('moip_desconto_cartao')) {
            if ($this->config->get('moip_desconto_cartao_tipo') == 'P') {
                return (($this->config->get('moip_desconto_cartao')/100) * $this->cart->getSubTotal()) * 100;
            } else {
                return ($this->config->get('moip_desconto_cartao')*100);
            }
        }
        
        if ($payment_code == 'moip_debito' && $this->config->get('moip_desconto_debito')) {
            if ($this->config->get('moip_desconto_debito_tipo') == 'P') {
                return (($this->config->get('moip_desconto_debito')/100) * $this->cart->getSubTotal()) * 100;
            } else {
                return ($this->config->get('moip_desconto_debito')*100);
            }
        }
    }
}