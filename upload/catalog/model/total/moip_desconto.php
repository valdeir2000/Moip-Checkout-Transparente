<?php
class ModelTotalMoipDesconto extends Model {
	public function getTotal($total) {
		if (isset($this->session->data['payment_method']['code'])) {
            
            $valor_desconto = 0;
            
			if ($this->session->data['payment_method']['code'] == 'moip_boleto') {
				
				$this->load->language('payment/moip');

				if (preg_match('/[%]/', $this->config->get('moip_desconto_boleto'))) {
					$percentual = preg_replace('/[^0-9.]/', '', $this->config->get('moip_desconto_boleto')) / 100;
					$valor_desconto = ($percentual * $this->cart->getSubTotal());
				} else {
					$valor_desconto = preg_replace('/[^0-9.]/', '', $this->config->get('moip_desconto_boleto'));
				}
				
			} elseif ($this->session->data['payment_method']['code'] == 'moip_cartao') {
				
				$this->load->language('payment/moip');

				if (preg_match('/[%]/', $this->config->get('moip_desconto_cartao'))) {
					$percentual = preg_replace('/[^0-9.]/', '', $this->config->get('moip_desconto_cartao')) / 100;
					$valor_desconto = ($percentual * $this->cart->getSubTotal());
				} else {
					$valor_desconto = preg_replace('/[^0-9.]/', '', $this->config->get('moip_desconto_cartao'));
				}
				
			} elseif ($this->session->data['payment_method']['code'] == 'moip_debito') {
				
				$this->load->language('payment/moip');

				if (preg_match('/[%]/', $this->config->get('moip_desconto_debito'))) {
					$percentual = preg_replace('/[^0-9.]/', '', $this->config->get('moip_desconto_debito')) / 100;
					$valor_desconto = ($percentual * $this->cart->getSubTotal());
				} else {
					$valor_desconto = preg_replace('/[^0-9.]/', '', $this->config->get('moip_desconto_debito'));
				}
			}
            
            if ($valor_desconto > 0) {
                $total['total'] -= $valor_desconto;
                
                $total['totals'][] = array(
					'code'       => 'moip_desconto',
					'title'      => $this->language->get('text_desconto'),
					'value'      => -$valor_desconto,
					'sort_order' => ($this->config->get('sub_total_sort_order') + 1)
				);
            }
		}
	}
}