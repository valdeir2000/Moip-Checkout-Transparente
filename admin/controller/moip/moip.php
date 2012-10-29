<?php class ControllerMoipMoip extends Controller {

	private $error = array();
	public function index() {
		
		$this->language->load('moip/moip');
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->getList();
	}
	
	public function getList() {
		/* Carrega o arquivo de linguagem */
		$this->language->load('moip/moip');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$url = '';
		
		/* Verifica se existe um filtro de busca por ID do pedido */
		if (isset($this->request->get['filter_order_id'])):
			$filter_order_id = $this->request->get['filter_order_id'];
			$url .= '&filter_order_id='.$this->request->get['filter_order_id'];
		else:
			$filter_order_id = null;
		endif;
		
		/* Verifica se existe um filtro de busca por nome do cliente */
		if (isset($this->request->get['filter_customer'])):
			$filter_customer = $this->request->get['filter_customer'];
			$url .= '&filter_customer='.$this->request->get['filter_customer'];
		else:
			$filter_customer = null;
		endif;
		
		/* Verifica se existe um filtro de busca por status */
		if (isset($this->request->get['filter_order_status_id'])):
			$filter_order_status_id = $this->request->get['filter_order_status_id'];
			$url .= '&filter_order_status_id='.$this->request->get['filter_order_status_id'];
		else:
			$filter_order_status_id = null;
		endif;
		
		/* Verifica se existe um filtro de busca por total do pedido */
		if (isset($this->request->get['filter_total'])):
			$filter_total = $this->request->get['filter_total'];
			$url .= '&filter_total='.$this->request->get['filter_total'];
		else:
			$filter_total = null;
		endif;
		
		/* Verifica se existe um filtro de busca por data de adiчуo */
		if (isset($this->request->get['filter_date_added'])):
			$filter_date_added = $this->request->get['filter_date_added'];
			$url .= '&filter_date_added='.$this->request->get['filter_date_added'];
		else:
			$filter_date_added = null;
		endif;
		
		/* Verifica se existe um filtro de busca por data de modificaчуo */
		if (isset($this->request->get['filter_date_modified'])):
			$filter_date_modified = $this->request->get['filter_date_modified'];
			$url .= '&filter_date_modified='.$this->request->get['filter_date_modified'];
		else:
			$filter_date_modified = null;
		endif;
		
		/* Verifica se existe um filtro de reogarnizaчуo por ordem Crescente ou Decrescente */
		if (isset($this->request->get['sort'])):
			$sort = $this->request->get['sort'];
			$url .= '&sort='.$this->request->get['sort'];
		else:
			$sort = null;
		endif;
		
		/* Verifica se existe um filtro de busca por 'order' */
		if (isset($this->request->get['order'])):
			$order = $this->request->get['order'];
			$url .= '&order='.$this->request->get['order'];
		else:
			$order = null;
		endif;
		
		/* Verifica em qual pсgina o usuсrio estс */
		if (isset($this->request->get['page'])):
			$page = $this->request->get['page'];
			$url .= '&page='.$this->request->get['page'];
		else:
			$page = 1;
		endif;
		
		/* Adiciona as vсriaveis acima nas variaveis $this-data[] para ser exibido no arquivo moip_form.tpl */
		$this->data['filter_order_id'] = $filter_order_id;
		$this->data['filter_customer'] = $filter_customer;
		$this->data['filter_status'] = $filter_order_status_id;
		$this->data['filter_total'] = $filter_total;
		$this->data['filter_date_added'] = $filter_date_added;
		$this->data['filter_date_modified'] = $filter_date_modified;
		
		/* Adiciona os valores das variaveis acima na variavщl $data (variavel responsavel por filtrar os resultados) */
		$data = array(
			'filter_order_id'        => $filter_order_id,
			'filter_customer'	     => $filter_customer,
			'filter_order_status_id' => $filter_order_status_id,
			'filter_total'           => $filter_total,
			'filter_date_added'      => $filter_date_added,
			'filter_date_modified'   => $filter_date_modified,
			'sort'                   => $sort,
			'order'                  => $order,
			'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  => $this->config->get('config_admin_limit')
		);
		
		/* Carrega o model moi/moip */
		$this->load->model('moip/moip');
		
		/* Carrega o model com as informaчѕes de status */
		$this->load->model('localisation/order_status');
		
		/* Adiciona os informaчѕes de dados na variсvel */
    	$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		/* Captura todas os pedidos com os filtros definidos mais acima */
		$results = $this->model_moip_moip->getOrders($data);
		
		/* Captura o total de compras */
		$order_total = $this->model_moip_moip->getTotalOrders($data);
		
		
		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => 'Visualizar',
				'href' => $this->url->link('moip/moip/getInfo', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'], 'SSL')
			);
			
			/* Adiciona os dados no array $this->data['orders'][]  */
			$this->data['orders'][] = array(
				'order_id'      => $result['order_id'],
				'customer'      => $result['customer'],
				'status'        => $result['status'],
				'total'         => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
				'date_added'    => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'date_modified' => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
				'selected'      => isset($this->request->post['selected']) && in_array($result['order_id'], $this->request->post['selected']),
				'action'        => $action
			);
			
		}
		
		/* Pсginaчуo */
		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('moip/moip', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
		$this->data['pagination'] = $pagination->render();
		
		/* Breadcrumbs - Inicio */
		$url = '';
				
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
                
		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('report/product_viewed', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
        );
        /* Breadcrumbs - Fim */
		
		$this->template = 'moip/moip_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	public function getInfo() {
		
		/* Carrega o arquivo de linguagem */
		$this->load->language('moip/moip');
		$this->document->setTitle('MoIP | Info');
		
		/* Carrega o model moip */
		$this->load->model('moip/moip');
		
		/* Verifica se o existe ou se estс vazio o parтmetro, caso esteja redireciona */
		if (!isset($this->request->get['order_id']) || empty($this->request->get['order_id']))
			$this->redirect($this->url->link('moip/moip&token=' . $this->session->data['token'] , '', 'SSL'));
		
		/* Recebe o ID da compra passado pela url */		
		$order_id = $this->request->get['order_id'];
		
		/* Captura os dados da compra selecionada */
		$this->data['data_order'] = $this->model_moip_moip->getOrder($order_id);
		
		/* Formata Moeda */
		$this->data['data_order']['total'] = $this->currency->format($this->data['data_order']['currency_id'], $this->data['data_order']['currency_code'], $this->data['data_order']['total']);
		
		/* Captura o nome do grupo do cliente */
		$this->data['data_order']['customer_group_name'] = $this->model_moip_moip->getCustomerGroup($this->data['data_order']['customer_group_id']);
		
		$this->data['data_order']['order_status_name'] = $this->model_moip_moip->getOrderStatus($this->data['data_order']['order_status_id']);
		
		$this->data['data_order']['commission'] = $this->currency->format($this->data['data_order']['currency_id'], $this->data['data_order']['currency_code'], $this->data['data_order']['commission']);
		
		/* Captura os dados dos produtos da compra */
		$this->data['data_products'] = $this->model_moip_moip->getOrderProducts($order_id);
		
		/* Captura o sub-total, valor do frete e valor total */
		$this->data['totals_order'] = $this->model_moip_moip->getOrderTotals($order_id);
		
		/* Captura todos os histѓricos criado */
		$histories_order = $this->model_moip_moip->getOrderHistories($order_id,0,40);
		
		$this->data['histories_order'] = array();
		
		foreach ($histories_order as $hitory_order):
			
			$this->data['histories_order'][] = array(
				'date_added' => date('d/m/Y', strtotime($hitory_order['date_added'])),
				'status'     => $hitory_order['status'],
				'comment'    => $hitory_order['comment'],
				'notify'     => $hitory_order['notify'] ? 'Sim' : 'Nao'
			);
			
		endforeach;
		
		/* Captura os dados da tabela moip_nasp e adiciona nas variaveis citadas abaixo */
		$this->data['moip_order'] = $this->model_moip_moip->getMoipNasp($order_id);
		
		/* Adiciona o simbolo R$ antes do valor */
		$this->data['moip_order']['valor'] = 'R$'.$this->format_money($this->data['moip_order']['valor']);
		
		/* Captura o nome do status de pagamento atraves do ID */
		$this->data['moip_order']['status_pagamento'] = $this->model_moip_moip->getStatusPaymentMoip($this->data['moip_order']['status_pagamento']);
		
		/* Captaura o nome da forma de pagamento */
		$this->data['moip_order']['forma_pagamento'] = $this->model_moip_moip->getFormaPagamento($this->data['moip_order']['forma_pagamento']);
		
		/* Concatena os 6 primeiros e 4 њltimos digitos do cartуo */
		$this->data['moip_order']['num_cartao'] = $this->data['moip_order']['cartao_bin'].'.****.****.'.$this->data['moip_order']['cartao_final'];
		
		/* Links */
		$this->data['link_order_update'] = $this->url->link('sale/order/info&token=' . $this->session->data['token'] . '&order_id=' . $order_id, '', 'SSL');
		$this->data['link_cancel'] = $this->url->link('moip/moip&token=' . $this->session->data['token'] . '&order_id=' . $order_id, '', 'SSL');
		
		/* Breadcrumbs - Inicio */
		$this->data['breadcrumbs'] = array();
		
		$this->data['breadcrumbs'][] = array(
			'separator' => false,
			'href' => $this->url->link('common/home&token=' . $this->session->data['token']),
			'text' => 'Principal'
		);
		
		$this->data['breadcrumbs'][] = array(
			'separator' => ' :: ',
			'href' => $this->url->link('common/home&token=' . $this->session->data['token']),
			'text' => 'MoIP'
		);
		/* Breadcrumbs - Fim */
		
		$this->template = 'moip/moip_info.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
		
		$this->response->setOutput($this->render());
		
	}
	
	public function teste() {
		
		$this->load->model('moip/moip');
		
		$resultado = $this->model_moip_moip->getOrder(9);
		$resultado2 = $this->model_moip_moip->getOrderProducts(9);
		
		var_dump($resultado);
		var_dump($resultado2);
		
		$this->template = 'moip/testes.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
		
		$this->response->setOutput($this->render());
		
	}

	private function format_money($total){
			if(strlen($total)>2){
				$n=strlen($total)-2;
				$preco=substr($total,0,$n).",".substr($total,$n);
				return $preco;
			}else{
				return $total;
			}
	}
}
?>