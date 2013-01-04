<?php
/**
 * MoIP NASP
 *
 * @author Valdeir Santana <valdeirpsr@hotmail.com.br>
 * @version 1.0.0
 * @license <a href="http://www.opensource.org/licenses/bsd-license.php">BSD License</a>
 */

//Inclui as variaveis globais
require_once 'config.php';
//Inclui o startup
require_once DIR_SYSTEM . 'startup.php';

//Conecta ao banco de dados
$db = new DB (DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

//Instancia um novo objeto Language
$languageMail = new Language('portuguese-br');

//Carrega o arquivo 
$languageMail->load('mail/moip');

//Captura a quantidade de dados da tabela moip_nasp
$id_transacao = $db->query('SELECT * FROM ' . DB_PREFIX . 'moip_nasp WHERE id_transacao = "' . $_POST['id_transacao'] . '"');
//Captura todos os dados do moip da tabela setting
$status_moip  = $db->query('SELECT * FROM ' . DB_PREFIX . 'setting WHERE `group` = "moip" ORDER BY setting_id');
//Captura os dados da tabela setting
$config       = $db->query('SELECT `key`,`value` FROM `' . DB_PREFIX . 'setting` WHERE  `group` = "config" OR `group` = "moip"');

//Captura o valor da chave notificação, autorizado, iniciado, boleto impresso, concluido, cancelado, em analise, estornado, em revisão e reembolsado.
$notify        = $status_moip->rows[5]['value'];
$autorizado    = $status_moip->rows[8]['value'];
$iniciado      = $status_moip->rows[9]['value'];
$boletImpresso = $status_moip->rows[10]['value'];
$concluido     = $status_moip->rows[11]['value'];
$cancelado     = $status_moip->rows[12]['value'];
$emAnalise     = $status_moip->rows[13]['value'];
$estornado     = $status_moip->rows[14]['value'];
$emRevisao     = $status_moip->rows[15]['value'];
$reembolsado   = $status_moip->rows[16]['value'];

//Captura o id enviado pelo moip, compara com os valores da variaveis acima
switch ($_POST['status_pagamento']) {
	case 1 :
		$status = $autorizado;
		break;
	
	case 2 :
		$status = $iniciado;
		break;
	
	case 3 :
		$status = $boletImpresso;
		break;
	
	case 4 :
		$status = $concluido;
		break;
	
	case 5 :
		$status = $cancelado;
		break;
	
	case 6 :
		$status = $emAnalise;
		break;
}

//Caso já exista o id recebido pelo moip na tabela moip_nasp, ele atualiza as tabelas moip_nasp e order
if (!empty($id_transacao->row)) {
	$db->query('UPDATE ' . DB_PREFIX . 'moip_nasp SET status_pagamento="' . $status . '" WHERE id_transacao = "' . $_POST['id_transacao'] . '"');
}else{
	if (empty($_POST['cartao_bin'])):
		$cartaoBin = 'Indefinido';
	else:
		$cartaoBin = $_POST['cartao_bin'];
	endif;
	
	if (empty($_POST['cartao_final'])):
		$cartaoFinal = 'Indefinido';
	else:
		$cartaoFinal = $_POST['cartao_final'];
	endif;
	
	if (empty($_POST['cartao_bandeira'])):
		$cartaoBandeira = 'Indefinido';
	else:
		$cartaoBandeira = $_POST['cartao_bandeira'];
	endif;
	
	if (empty($_POST['cofre'])):
		$cartaoCofre = 'Indefinido';
	else:
		$cartaoCofre = $_POST['cofre'];
	endif;
	
	//Caso não exista o id recebido pelo moip na tabela moip_nasp, inseri os dados recebidos do moip na tabela moip_nasp
	$db->query("INSERT INTO `" . DB_PREFIX . "moip_nasp` (
				`id_transacao`, 
				`valor`, 
				`status_pagamento`, 
				`cod_moip`, 
				`tipo_pagamento`, 
				`forma_pagamento`, 
				`parcelas`, 
				`email_consumidor`, 
				`cartao_bin`, 
				`cartao_final`, 
				`cartao_bandeira`, 
				`cofre`) 
				VALUES (
				'" . $_POST['id_transacao'] . "', 
				'" . $_POST['valor'] . "', 
				'" . $_POST['status_pagamento'] . "', 
				'" . $_POST['cod_moip'] . "', 
				'" . $_POST['tipo_pagamento'] . "', 
				'" . $_POST['forma_pagamento'] . "', 
				'" . $_POST['parcelas'] . "', 
				'" . $_POST['email_consumidor'] . "', 
				'" . $cartaoBin . "', 
				'" . $cartaoFinal . "', 
				'" . $cartaoBandeira . "', 
				'" . $cartaoCofre . "');");
}


$db->query('UPDATE `' . DB_PREFIX . 'order` SET order_status_id = "' . $status . '" WHERE order_id = "' . $_POST['id_transacao'] . '"');
	
$mensagem = '';

//Verifica se a opção notificação do cliente está ativa, caso esteja:
if ($notify) {

	//Captura o nome do status recebido pelo moip,
	$status_order = $db->query('SELECT * FROM ' . DB_PREFIX . 'order_status WHERE order_status_id = "' . $status . '"');
	
	//Captura as configurações de email para o envio
	for ($i = 0;$i < count($config->rows);$i++) {
		
		if ($config->rows[$i]['key'] == 'config_mail_protocol') {
			$config_mail_protocol = $config->rows[$i]['value'];
		}
		
		if ($config->rows[$i]['key'] == 'config_mail_parameter') {
			$config_mail_parameter = $config->rows[$i]['value'];
		}
		
		if ($config->rows[$i]['key'] == 'config_smtp_host') {
			$config_smtp_host = $config->rows[$i]['value'];
		}
		
		if ($config->rows[$i]['key'] == 'config_smtp_username') {
			$config_smtp_username = $config->rows[$i]['value'];
		}
		
		if ($config->rows[$i]['key'] == 'config_smtp_password') {
			$config_smtp_password = $config->rows[$i]['value'];
		}
		
		if ($config->rows[$i]['key'] == 'config_smtp_port') {
			$config_smtp_port = $config->rows[$i]['value'];
		}
		
		if ($config->rows[$i]['key'] == 'config_smtp_timeout') {
			$config_smtp_timeout = $config->rows[$i]['value'];
		}
		
		if ($config->rows[$i]['key'] == 'config_email') {
			$config_email = $config->rows[$i]['value'];
		}
		
		if ($config->rows[$i]['key'] == 'config_name') {
			$config_name = $config->rows[$i]['value'];
		}	
	}
		
	//Cria uma mensagem para enviar ao cliente
	$assunto = sprintf($languageMail->get('text_update_subject'), $config_name, $_POST['id_transacao']);
	$mensagem = $languageMail->get('text_update_order') . ' ' . $_POST['id_transacao'] . ' <br/>';
	$mensagem .= $languageMail->get('text_update_date_added') . ' ' . date('d/m/Y h:m:s') . '<br/>';
	$mensagem .= $languageMail->get('text_update_order_status') . '<br/><strong>'. $status_order->row['name'] .'</strong><br/><br/>';
	$mensagem .= $languageMail->get('text_method_payment') . '<br/><strong>MoiP - '. $_POST['tipo_pagamento'] .'</strong><br/><br/>';
	$mensagem .= $languageMail->get('text_update_link') . '<br/>';
	$mensagem .= '<a href="'. HTTP_SERVER . 'index.php?route=account/order/info&order_id='. $_POST['id_transacao'] . '">'. HTTP_SERVER . 'index.php?route=account/order/info&order_id='. $_POST['id_transacao'] . '</a><br/><br/>';
	$mensagem .= $languageMail->get('text_update_footer');

	$mail = new Mail();
	$mail->protocol = $config_mail_protocol;
	$mail->parameter = $config_mail_parameter;
	$mail->hostname = $config_smtp_host;
	$mail->username = $config_smtp_username;
	$mail->password = $config_smtp_password;
	$mail->port = $config_smtp_port;
	$mail->timeout = $config_smtp_timeout;
	$mail->setTo($_POST['email_consumidor']);
	$mail->setFrom($config_email);
	$mail->setSender($config_name);
	$mail->setSubject(html_entity_decode($assunto, ENT_QUOTES, 'UTF-8'));
	$mail->setHtml($mensagem, ENT_NOQUOTES);
	$mail->send();
}

//Adiciona a alteração na tabela order_history (histórico de pedido)
$db->query("INSERT INTO `". DB_PREFIX ."order_history` (`order_id`, `order_status_id`, `notify`, `comment`, `date_added`) VALUES ('".$_POST['id_transacao']."', '".$status."', '".$notify."', '".$db->escape(strip_tags($mensagem))."', NOW())");
	


?>