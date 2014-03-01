<?php 
class ControllerPaymentMoip extends Controller {
    private $error = array(); 

    public function index() {
		/* Carrega o arquivo de linguagem */
        $this->load->language('payment/moip');
		
		/* Define o <title></title> com o título do módulo */
        $this->document->setTitle($this->language->get('heading_title'));
		
		/* Carrega o model de configurções */
        $this->load->model('setting/setting');
		
		/* Salva as informações */
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
            $this->load->model('setting/setting');
			
			$this->model_setting_setting->editSetting('moip', $this->request->post);				

            $this->session->data['success'] = $this->language->get('text_success');

            $this->redirect(HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token']);
        }

        $this->data['heading_title'] = $this->language->get('heading_title');
		
		/* Text */
        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_all_zones'] = $this->language->get('text_all_zones');
        $this->data['text_yes'] = $this->language->get('text_yes');
        $this->data['text_no'] = $this->language->get('text_no');
		
		/* Tabs */
		$this->data['tab_config'] = $this->language->get('tab_config');
		$this->data['tab_status'] = $this->language->get('tab_status');
		$this->data['tab_order'] = $this->language->get('tab_order');
		$this->data['tab_parcelas'] = $this->language->get('tab_parcelas');
		$this->data['tab_boleto'] = $this->language->get('tab_boleto');
		$this->data['tab_formasPagamento'] = $this->language->get('tab_formasPagamento');
		$this->data['tab_committee'] = $this->language->get('tab_committee');
		$this->data['tab_suporte'] = $this->language->get('tab_suporte');
		
		/* Entry - Configurações */
        $this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_razao'] = $this->language->get('entry_razao');
		$this->data['entry_apitoken'] = $this->language->get('entry_apitoken');
        $this->data['entry_apikey'] = $this->language->get('entry_apikey');
        $this->data['entry_test'] = $this->language->get('entry_test');
        $this->data['entry_notify'] = $this->language->get('entry_notify');
		$this->data['entry_modoParcela'] = $this->language->get('entry_modoParcela');
		$this->data['entry_valorTotal'] = $this->language->get('entry_valorTotal');
		$this->data['entry_stepFive'] = $this->language->get('entry_stepFive');
		
		/* Entry - Status de Pagamento */
		$this->data['entry_autorizdo'] = $this->language->get('entry_autorizdo');
        $this->data['entry_iniciado'] = $this->language->get('entry_iniciado');
        $this->data['entry_boletoimpresso'] = $this->language->get('entry_boletoimpresso');
        $this->data['entry_concluido'] = $this->language->get('entry_concluido');
        $this->data['entry_cancelado'] = $this->language->get('entry_cancelado');
        $this->data['entry_emanalise'] = $this->language->get('entry_emanalise');
        $this->data['entry_estornado'] = $this->language->get('entry_estornado');
        $this->data['entry_revisao'] = $this->language->get('entry_revisao');
        $this->data['entry_reembolsado'] = $this->language->get('entry_reembolsado');
		
		/* Entry - Área e Ordem */
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');	
		
		/* Entry - Parcelas */
        $this->data['entry_parcelaDe'] = $this->language->get('entry_parcelaDe');
        $this->data['entry_parcelaPara'] = $this->language->get('entry_parcelaPara');
        $this->data['entry_parcelaJuros'] = $this->language->get('entry_parcelaJuros');
		
		/* Entry - Boleto */
        $this->data['entry_boletoPrazo'] = $this->language->get('entry_boletoPrazo');
        $this->data['entry_boletoInstrucao'] = $this->language->get('entry_boletoInstrucao');
        $this->data['entry_boletoUrlLogo'] = $this->language->get('entry_boletoUrlLogo');
		
		/* Entry - Formas de Pagamento */
        $this->data['entry_cartaoCredito'] = $this->language->get('entry_cartaoCredito');
        $this->data['entry_boleto'] = $this->language->get('entry_boleto');
        $this->data['entry_debito'] = $this->language->get('entry_debito');
		
		/* Entry - Suporte */
        $this->data['entry_suporteAssunto'] = $this->language->get('entry_suporteAssunto');
        $this->data['entry_suporteMensagem'] = $this->language->get('entry_suporteMensagem');
        $this->data['attention_suporte'] = $this->language->get('attention_suporte');
        $this->data['success_suporte'] = $this->language->get('success_suporte');
		
		/* Helps */
		$this->data['help_razao'] = $this->language->get('help_razao');
		$this->data['help_notify'] = $this->language->get('help_notify');
		$this->data['help_autorizado'] = $this->language->get('help_autorizado');
        $this->data['help_iniciado'] = $this->language->get('help_iniciado');
        $this->data['help_boletoimpresso'] = $this->language->get('help_boletoimpresso');
        $this->data['help_concluido'] = $this->language->get('help_concluido');
        $this->data['help_cancelado'] = $this->language->get('help_cancelado');
        $this->data['help_emanalise'] = $this->language->get('help_emanalise');
        $this->data['help_estornado'] = $this->language->get('help_estornado');
        $this->data['help_revisao'] = $this->language->get('help_revisao');
        $this->data['help_reembolsado'] = $this->language->get('help_reembolsado');
        $this->data['help_boletoUrlLogo'] = $this->language->get('help_boletoUrlLogo');
        $this->data['help_stepFive'] = $this->language->get('help_stepFive');
		
		/* Botões */
		$this->data['button_adicionar'] = $this->language->get('button_adicionar');
        $this->data['button_remover'] = $this->language->get('button_remover');
        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');
        $this->data['button_enviar'] = $this->language->get('button_enviar');
		
		/* Error */
        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

		/* Error */
        $this->data['error_email'] = $this->language->get('error_email');
	$this->data['error_assunto'] = $this->language->get('error_assunto');
	$this->data['error_mensagem'] = $this->language->get('error_mensagem');
		
		/* Breadcrumbs - Inicio */
        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'href'      => $this->url->link('common/home&token=', $this->session->data['token']),
            'text'      => $this->language->get('text_home'),
            'separator' => FALSE
        );

        $this->data['breadcrumbs'][] = array(
            'href'      => $this->url->link('extension/payment&token=',$this->session->data['token']),
            'text'      => $this->language->get('text_payment'),
            'separator' => ' :: '
        );

        $this->data['breadcrumbs'][] = array(
            'href'      => $this->url->link('payment/moip&token=', $this->session->data['token']),
            'text'      => $this->language->get('heading_title'),
            'separator' => ' :: '
        );
		/* Breadcrumbs - Fim */
		
		/* Botões */
        $this->data['action'] = $this->url->link('payment/moip', 'token=' . $this->session->data['token']);
        $this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token']);
		
		/* Status */
        if (isset($this->request->post['moip_status'])) {
            $this->data['moip_status'] = $this->request->post['moip_status'];
        } else {
            $this->data['moip_status'] = $this->config->get('moip_status'); 
        }
		
		/* Notify */
		if (isset($this->request->post['moip_notify'])) {
            $this->data['moip_notify'] = $this->request->post['moip_notify'];
        } else {
            $this->data['moip_notify'] = $this->config->get('moip_notify'); 
        }
		
		/* Modo Teste */
        if (isset($this->request->post['moip_test'])) {
            $this->data['moip_test'] = $this->request->post['moip_test'];
        } else {
            $this->data['moip_test'] = $this->config->get('moip_test'); 
        } 
		
		/* Razão */
        if (isset($this->request->post['moip_razao'])) {
            $this->data['moip_razao'] = $this->request->post['moip_razao'];
        } else {
            $this->data['moip_razao'] = $this->config->get('moip_razao');
        }
        
        /* Token */
        if (isset($this->request->post['moip_apitoken'])) {
            $this->data['moip_apitoken'] = $this->request->post['moip_apitoken'];
        } else {
            $this->data['moip_apitoken'] = $this->config->get('moip_apitoken');
        }
        
       /* Key */
        if (isset($this->request->post['moip_apikey'])) {
            $this->data['moip_apikey'] = $this->request->post['moip_apikey'];
        } else {
            $this->data['moip_apikey'] = $this->config->get('moip_apikey');
        }
		
		/* Etapa 5 (Checkout) */
		if (isset($this->request->post['stepFive'])){
			$this->data['stepFive'] = $this->request->post['stepFive'];
		}else{
			$this->data['stepFive'] = $this->config->get('stepFive');
		}
		
		/* Autorizado */
        if (isset($this->request->post['moip_apikey'])) {
            $this->data['moip_autorizado'] = $this->request->post['moip_autorizado'];
        } else {
            $this->data['moip_autorizado'] = $this->config->get('moip_autorizado');
        }
		
		/* Iniciado */
        if (isset($this->request->post['moip_iniciado'])) {
            $this->data['moip_iniciado'] = $this->request->post['moip_iniciado'];
        } else {
            $this->data['moip_iniciado'] = $this->config->get('moip_iniciado');
        }
		
		/* Boleto Impresso */
        if (isset($this->request->post['moip_boletoimpresso'])) {
            $this->data['moip_boletoimpresso'] = $this->request->post['moip_boletoimpresso'];
        } else {
            $this->data['moip_boletoimpresso'] = $this->config->get('moip_boletoimpresso');
        }
		
		/* Concluido */
        if (isset($this->request->post['moip_concluido'])) {
            $this->data['moip_concluido'] = $this->request->post['moip_concluido'];
        } else {
            $this->data['moip_concluido'] = $this->config->get('moip_concluido');
        }
		
		/* Cancelado */
        if (isset($this->request->post['moip_cancelado'])) {
            $this->data['moip_cancelado'] = $this->request->post['moip_cancelado'];
        } else {
            $this->data['moip_cancelado'] = $this->config->get('moip_cancelado');
        }
		
		/* Em Análise */
        if (isset($this->request->post['moip_emanalise'])) {
            $this->data['moip_emanalise'] = $this->request->post['moip_emanalise'];
        } else {
            $this->data['moip_emanalise'] = $this->config->get('moip_emanalise');
        }
		
		/* Estornado */
        if (isset($this->request->post['moip_estornado'])) {
            $this->data['moip_estornado'] = $this->request->post['moip_estornado'];
        } else {
            $this->data['moip_estornado'] = $this->config->get('moip_estornado');
        }
		
		/* Em Revisão */
        if (isset($this->request->post['moip_revisao'])) {
            $this->data['moip_revisao'] = $this->request->post['moip_revisao'];
        } else {
            $this->data['moip_revisao'] = $this->config->get('moip_revisao');
        }
		
		/* Reembolsado */
        if (isset($this->request->post['moip_reembolsado'])) {
            $this->data['moip_reembolsado'] = $this->request->post['moip_reembolsado'];
        } else {
            $this->data['moip_reembolsado'] = $this->config->get('moip_reembolsado');
        }
		
		/* Parcelas */
        if (isset($this->request->post['moip_parcelas'])) {
            $this->data['moip_parcelas'] = serialize($this->request->post['moip_parcelas']);
        } else {
            $this->data['moip_parcelas'] = $this->config->get('moip_parcelas');
        }

		/* Carrega o model de locação de zona geográfica */
        $this->load->model('localisation/geo_zone');
		
		/* Captura todas as zonas */
        $this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		/* Zone Selecionada */
        if (isset($this->request->post['moip_geo_zone_id'])) {
            $this->data['moip_geo_zone_id'] = $this->request->post['moip_geo_zone_id'];
        } else {
            $this->data['moip_geo_zone_id'] = $this->config->get('moip_geo_zone_id'); 
        }

        /* Status do pedido quando estive aguardando pagamento pelo moip */
        if (isset($this->request->post['moip_aguardando'])) {
            $this->data['moip_aguardando'] = $this->request->post['moip_aguardando'];
        } else {
            $this->data['moip_aguardando'] = $this->config->get('moip_aguardando'); 
        } 
        /* Status do pedido quando for cancelado pelo moip */
        if (isset($this->request->post['moip_cancelado'])) {
            $this->data['moip_cancelado'] = $this->request->post['moip_cancelado'];
        } else {
            $this->data['moip_cancelado'] = $this->config->get('moip_cancelado'); 
        } 
        /* Status do pedido quando for aprovando pelo moip */
        if (isset($this->request->post['moip_aprovado'])) {
            $this->data['moip_aprovado'] = $this->request->post['moip_aprovado'];
        } else {
            $this->data['moip_aprovado'] = $this->config->get('moip_aprovado'); 
        } 
        /* Status do pedido quando for Analize pelo moip */
        if (isset($this->request->post['moip_analize'])) {
            $this->data['moip_analize'] = $this->request->post['moip_analize'];
        } else {
            $this->data['moip_analize'] = $this->config->get('moip_analize'); 
        } 
        
		/* Dias corridos para o prazo do boleto */
        if (isset($this->request->post['moip_diasCorridosBoleto'])) {
            $this->data['moip_diasCorridosBoleto'] = $this->request->post['moip_diasCorridosBoleto'];
        } else {
            $this->data['moip_diasCorridosBoleto'] = $this->config->get('moip_diasCorridosBoleto'); 
        }
		
		/* Instrução 1 do boleto */
        if (isset($this->request->post['moip_instrucaoUmBoleto'])) {
            $this->data['moip_instrucaoUmBoleto'] = $this->request->post['moip_instrucaoUmBoleto'];
        } else {
            $this->data['moip_instrucaoUmBoleto'] = $this->config->get('moip_instrucaoUmBoleto'); 
        }
		
		/* Instrução 2 do Boleto */
        if (isset($this->request->post['moip_instrucaoDoisBoleto'])) {
            $this->data['moip_instrucaoDoisBoleto'] = $this->request->post['moip_instrucaoDoisBoleto'];
        } else {
            $this->data['moip_instrucaoDoisBoleto'] = $this->config->get('moip_instrucaoDoisBoleto'); 
        }
		
		/* Instrução 3 do Boleto */
        if (isset($this->request->post['moip_instrucaoTresBoleto'])) {
            $this->data['moip_instrucaoTresBoleto'] = $this->request->post['moip_instrucaoTresBoleto'];
        } else {
            $this->data['moip_instrucaoTresBoleto'] = $this->config->get('moip_instrucaoTresBoleto'); 
        }
		
		/* Url da Logo para o Boleto */
        if (isset($this->request->post['moip_urlLogoBoleto'])) {
            $this->data['moip_urlLogoBoleto'] = $this->request->post['moip_urlLogoBoleto'];
        } else {
            $this->data['moip_urlLogoBoleto'] = $this->config->get('moip_urlLogoBoleto'); 
        }
		
		/* Modo como as parcelas irão ser exibidas */
        if (isset($this->request->post['moip_modoParcelas'])) {
            $this->data['moip_modoParcelas'] = $this->request->post['moip_modoParcelas'];
        } else {
            $this->data['moip_modoParcelas'] = $this->config->get('moip_modoParcelas'); 
        }
		
		/* Exibi valor total das parcelas */
        if (isset($this->request->post['moip_exibiTotalParcela'])) {
            $this->data['moip_exibiTotalParcela'] = $this->request->post['moip_exibiTotalParcela'];
        } else {
            $this->data['moip_exibiTotalParcela'] = $this->config->get('moip_exibiTotalParcela'); 
        }
		
		/* Carrega o model order_status */
        $this->load->model('localisation/order_status');
		
		/* Captura todos os status cadastrado */
        $this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		/* Ordem do Módulo */
        if (isset($this->request->post['moip_sort_order'])) {
            $this->data['moip_sort_order'] = $this->request->post['moip_sort_order'];
        } else {
            $this->data['moip_sort_order'] = $this->config->get('moip_sort_order');
        }
		
		/* Acc Cartão de Crédito */
        if (isset($this->request->post['moip_accCartaoCredito'])) {
            $this->data['moip_accCartaoCredito'] = $this->request->post['moip_accCartaoCredito'];
        } else {
            $this->data['moip_accCartaoCredito'] = $this->config->get('moip_accCartaoCredito');
        }

		/* Acc Boleto */
        if (isset($this->request->post['moip_accBoleto'])) {
            $this->data['moip_accBoleto'] = $this->request->post['moip_accBoleto'];
        } else {
            $this->data['moip_accBoleto'] = $this->config->get('moip_accBoleto');
        }

		/* Acc Débito */
        if (isset($this->request->post['moip_accDebito'])) {
            $this->data['moip_accDebito'] = $this->request->post['moip_accDebito'];
        } else {
            $this->data['moip_accDebito'] = $this->config->get('moip_accDebito');
        }

		/* Captura quais layouts serão carregados */
        $this->id       = 'content';
        $this->template = 'payment/moip.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
		
		/* Carrega Layout */
        $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
    }
	
	/* Função Para envio do Suporte */
	public function suporte() {
		
		$assunto = $this->request->get['suporteAssunto'];
		$mensagem = $this->request->get['suporteMensagem'];
		$mensagem .= '<br/><br/>Site: '.HTTP_CATALOG;
		
		$mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->hostname = $this->config->get('config_smtp_host');
		$mail->username = $this->config->get('config_smtp_username');
		$mail->password = $this->config->get('config_smtp_password');
		$mail->port = $this->config->get('config_smtp_port');
		$mail->timeout = $this->config->get('config_smtp_timeout');
		$mail->setTo('valdeirpsr@hotmail.com.br');
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender($this->config->get('config_name'));
		$mail->setSubject($assunto);
		$mail->setHTML($mensagem);
		$mail->send();
	}
	
	/* Função para validar os dados quando usuário salvar */
    private function validate() {
        if (!$this->user->hasPermission('modify', 'payment/moip')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
		
		if (!$this->request->post['moip_apitoken']) {
			$this->error['erro_apitoken'] = $this->language->get('erro_apitoken');
		}
		
		if (!$this->request->post['moip_apikey']) {
			$this->error['erro_apikey'] = $this->language->get('erro_apikey');
		}

        if (!@$this->request->post['moip_razao']) {
            $this->error['error_razao'] = $this->language->get('error_razao');
        }
		
		if ($this->request->post['stepFive'] == 1){
			if (file_exists(DIR_CATALOG . 'vqmod/xml/pular_etapa5_moip')){
				rename (DIR_CATALOG . 'vqmod/xml/pular_etapa5_moip', DIR_CATALOG . 'vqmod/xml/pular_etapa5_moip.xml');
			}
		}else{
			if (file_exists(DIR_CATALOG . 'vqmod/xml/pular_etapa5_moip.xml')){
				rename (DIR_CATALOG . 'vqmod/xml/pular_etapa5_moip.xml', DIR_CATALOG . 'vqmod/xml/pular_etapa5_moip');
			}
		}

        if (!$this->error) {
            return TRUE;
        } else {
            return FALSE;
        }	
    }
}
?>
