<?php
	
	//Inclui as variaveis globais
	require_once '../../../config.php';
	//Inclui o startup
	require_once DIR_SYSTEM . 'startup.php';
	
	$session = new Cache();
	
	$sessao = $session->get('logado');
	
	if (!isset($sessao) || empty($sessao) || $sessao != 'sim'):
		ini_set('sefault_charset', 'UTF-8');
		header('Location:index.php');
	endif;
	
	//Conecta ao banco de dados
	$db = new DB (DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
	
	$sql_zone = "SELECT * FROM " . DB_PREFIX . "geo_zone ORDER BY name DESC";
	$query_zone = $db->query($sql_zone);
	
	$sql_language = "SELECT * FROM " . DB_PREFIX . "language  ORDER BY sort_order, name DESC";
	$query_language = $db->query($sql_language);
	
	$language_id = 1;
	
	foreach ($query_language->rows as $language):
		if ($language['code'] == 'pt-br'):
			$language_id = $language['language_id'];
		endif;
	endforeach;
	
	$sql_status = "SELECT * FROM " . DB_PREFIX . "order_status WHERE language_id = '" . $language_id . "' ORDER BY name DESC";
	$query_status = $db->query($sql_status);
	
	function editSetting($group, $data, $store_id = 0) {
		global $db;
		
		$db->query("DELETE FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `group` = '" . $db->escape($group) . "'");

		foreach ($data as $key => $value) {
			if (!is_array($value)) {
				$db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `group` = '" . $db->escape($group) . "', `key` = '" . $db->escape($key) . "', `value` = '" . $db->escape($value) . "'");
			} else {
				$db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `group` = '" . $db->escape($group) . "', `key` = '" . $db->escape($key) . "', `value` = '" . $db->escape(serialize($value)) . "', serialized = '1'");
			}
		}
	}
	
	if (isset($_POST)):
		ini_set('default_charset', 'UTF-8');
		$db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "moip_nasp`");
		$db->query("DROP TABLE IF EXISTS `cartaocredito`");
		$db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "moip_nasp` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `id_transacao` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
					  `valor` int(11) NOT NULL,
					  `status_pagamento` int(11) NOT NULL,
					  `cod_moip` int(11) NOT NULL,
					  `forma_pagamento` int(11) NOT NULL,
					  `tipo_pagamento` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
					  `email_consumidor` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
					  `parcelas` int(255) NOT NULL DEFAULT '0',
					  `cartao_bin` int(255) NOT NULL DEFAULT '0',
					  `cartao_final` int(255) NOT NULL DEFAULT '0',
					  `cartao_bandeira` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Indefinido',
					  `cofre` varchar(36) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Indefinido',
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2047 ;");
		$db->query("CREATE TABLE IF NOT EXISTS `cartaocredito` (
				  `id_cartaoCredito` int(11) NOT NULL AUTO_INCREMENT,
				  `customer_id` int(11) NOT NULL,
				  `bandeiraCartao` varchar(1000) CHARACTER SET utf8 NOT NULL,
				  `titularCartao` varchar(1000) NOT NULL,
				  `numeroCartao` varchar(1000) NOT NULL,
				  `validadeCartao` varchar(1000) NOT NULL,
				  `codCartao` varchar(1000) NOT NULL,
				  `nascimentoTitular` varchar(1000) NOT NULL,
				  `telefoneTitular` varchar(1000) NOT NULL,
				  `CPFTitular` varchar(1000) NOT NULL,
				  PRIMARY KEY (`id_cartaoCredito`)
				) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;");
		$db->query("INSERT INTO " . DB_PREFIX . "extension SET `type` = 'payment', `code` = 'moip'");
		
		//Captura todas configurações da loja
		$config = $db->query('SELECT `key`,`value` FROM `' . DB_PREFIX . 'setting` WHERE  `group` = "config" OR `group` = "moip"');
		
		//Etapa 5
		if (isset($_POST['stepFive']) && $_POST['stepFive'] == 1){
			if (file_exists(DIR_SYSTEM . '../vqmod/xml/pular_etapa5_moip')){
				rename(DIR_SYSTEM . '../vqmod/xml/pular_etapa5_moip', DIR_SYSTEM . '../vqmod/xml/pular_etapa5_moip.xml');
			}
		}
		
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
		
		$mensagem = 'Houve uma instalação na loja <a href="' . HTTP_SERVER . '">' . $config_name . '</a>';
		
		$mail = new Mail();
		$mail->protocol = $config_mail_protocol;
		$mail->parameter = $config_mail_parameter;
		$mail->hostname = $config_smtp_host;
		$mail->username = $config_smtp_username;
		$mail->password = $config_smtp_password;
		$mail->port = $config_smtp_port;
		$mail->timeout = $config_smtp_timeout;
		$mail->setTo('valdeirpsr@hotmail.com.br');
		$mail->setFrom($config_email);
		$mail->setSender($config_name);
		$mail->setSubject(html_entity_decode('MoIP Instalado', ENT_QUOTES, 'UTF-8'));
		$mail->setHtml($mensagem, ENT_NOQUOTES);
		$mail->send();
		
		editSetting('moip', $_POST);
	endif;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Instalação MoIP</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="description" content="Fancy Sliding Form with jQuery" />
        <meta name="keywords" content="jquery, form, sliding, usability, css3, validation, javascript"/>
        <link rel="stylesheet" href="css/style.css" type="text/css" media="screen"/>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
        <script type="text/javascript" src="sliding.form.js"></script>
    </head>
    <style>
        span.reference{
            position:fixed;
            left:5px;
            top:5px;
            font-size:10px;
            text-shadow:1px 1px 1px #fff;
        }
        span.reference a{
            color:#555;
            text-decoration:none;
			text-transform:uppercase;
        }
        span.reference a:hover{
            color:#000;
            
        }
        h1{
            color:#ccc;
            font-size:36px;
            text-shadow:1px 1px 1px #fff;
            padding:20px;
        }
    </style>
    <body>
		
		<!--------------->
		<!--  Content  -->
		<!--------------->
        <div id="content">
			
			<!--------------->
			<!--  Warning  -->
			<!--------------->
			<?php if(isset($_GET['erro'])): ?>
			<div class="warning">Preencha todos os dados.</div>
			<?php endif; ?>
			
			<!--------------->
			<!--  Success  -->
			<!--------------->
			<div class="warning">Basta preencher apenas 1 vez.</div>
			
			<!--------------->
			<!--   Title   -->
			<!--------------->
            <h1>MoIP Checkout Transparente | Valdeir S.</h1>
            <h2 class="subTitle">Bem Vindo(a) a instalação</h2>
			
			<!---------------->
			<!--   Wrapper  -->
			<!---------------->
            <div id="wrapper">
				
				<!---------------->
				<!--    Steps   -->
				<!---------------->
                <div id="steps">
                    <form id="formElem" name="formElem" action="#" method="post">
                        
						<!------------------>
						<!-- Configurações-->
						<!------------------>
						<fieldset class="step">
                            <legend>Configurações</legend>
							
							<!-------------->
							<!--  Situação-->
							<!-------------->
                            <p>
                                <label for="moip_status">Situação: </label>
                                <select id="moip_status" name="moip_status">
									<option value="1">Habilitado</option>
									<option value="0">Desabilitado</option>
								</select>
                            </p>
							
							<!-------------->
							<!--   Razão  -->
							<!-------------->
                            <p>
                                <label for="moip_razao">Razão do Pagamento: </label>
                                <input id="moip_razao" name="moip_razao" AUTOCOMPLETE=OFF />
                            </p>
							
							<!-------------->
							<!--   Token  -->
							<!-------------->
                            <p>
                                <label for="moip_apitoken">Token: </label>
                                <input id="moip_apitoken" name="moip_apitoken" AUTOCOMPLETE=OFF />
                            </p>
							
							<!-------------->
							<!--    Key   -->
							<!-------------->
                            <p>
                                <label for="moip_apikey">Key: </label>
                                <input id="moip_apikey" name="moip_apikey" AUTOCOMPLETE=OFF />
                            </p>
							
							<!-------------->
							<!--Modo Teste-->
							<!-------------->
                            <p>
                                <label for="moip_test">Modo de Teste: </label>
								<select id="moip_test" name="moip_test">
									<option value="1">Sim</option>
									<option value="0">Não</option>
								</select>
                            </p>
							
							<!-------------->
							<!--  Notify  -->
							<!-------------->
                            <p>
                                <label for="moip_notify">Notificar Cliente: </label>
								<select id="moip_notify" name="moip_notify">
									<option value="1">Sim</option>
									<option value="0">Não</option>
								</select>
                            </p>
							
							<!---------------->
							<!--Modo Parcela-->
							<!---------------->
                            <p>
                                <label for="moip_modoParcelas">Exibi as parcelas com:</label>
								<select id="moip_modoParcelas" name="moip_modoParcelas">
									<option value="select">Select</option>
									<option value="radio">Radio Button</option>
									<option value="radio">Radio Button 2 Cols</option>
								</select>
                            </p>
							
							<!-------------->
							<!--ValorTotal-->
							<!-------------->
                            <p>
                                <label for="moip_exibiTotalParcela">Exibi valor total das parcelas?</label>
								<select id="moip_exibiTotalParcela" name="moip_exibiTotalParcela">
									<option value="1">Sim</option>
									<option value="0">Não</option>
								</select>
                            </p>
							
							<!------------------>
							<!--   Etapa 5  -->
							<!------------------>
							<p>
								<label for="stepFive">Deseja ocultar a etapa 5 (Método de Pagamento) do checkout?</label>
								<select name="stepFive" id="stepFive">
									<option value="1">Sim</option>
									<option value="0">Não</option>
								</select>
							</p>
                        </fieldset>
						
						<!---------------->
						<!--  Status P  -->
						<!---------------->
                        <fieldset class="step">
                            <legend>Status de Pagamento</legend>
                            
							<!--------------->
							<!-- Autorizado-->
							<!--------------->
							<p>
                                <label for="moip_autorizado">Situação Autorizado:</label>
                                <select id="moip_autorizado" name="moip_autorizado">
									<?php foreach($query_status->rows as $status): ?>
									<option value="<?php echo $status['order_status_id'] ?>"><?php echo $status['name'] ?></option>
									<?php endforeach; ?>
								</select>
                            </p>
							
							<!--------------->
							<!--  Iniciado -->
							<!--------------->
							<p>
                                <label for="moip_iniciado">Situação Iniciado:</label>
                                <select id="moip_iniciado" name="moip_iniciado">
									<?php foreach($query_status->rows as $status): ?>
									<option value="<?php echo $status['order_status_id'] ?>"><?php echo $status['name'] ?></option>
									<?php endforeach; ?>
								</select>
                            </p>
							
							<!--------------->
							<!--   Boleto  -->
							<!--------------->
							<p>
                                <label for="moip_boletoimpresso">Situação Boleto Impresso:</label>
                                <select id="moip_boletoimpresso" name="moip_boletoimpresso">
									<?php foreach($query_status->rows as $status): ?>
									<option value="<?php echo $status['order_status_id'] ?>"><?php echo $status['name'] ?></option>
									<?php endforeach; ?>
								</select>
                            </p>
							
							<!--------------->
							<!-- Concluido -->
							<!--------------->
							<p>
                                <label for="moip_concluido">Situação Concluído:</label>
                                <select id="moip_concluido" name="moip_concluido">
									<?php foreach($query_status->rows as $status): ?>
									<option value="<?php echo $status['order_status_id'] ?>"><?php echo $status['name'] ?></option>
									<?php endforeach; ?>
								</select>
                            </p>
							
							<!--------------->
							<!-- Cancelado -->
							<!--------------->
							<p>
                                <label for="moip_cancelado">Situação Cancelado:</label>
                                <select id="moip_cancelado" name="moip_cancelado">
									<?php foreach($query_status->rows as $status): ?>
									<option value="<?php echo $status['order_status_id'] ?>"><?php echo $status['name'] ?></option>
									<?php endforeach; ?>
								</select>
                            </p>
							
							<!--------------->
							<!-- Em Análise-->
							<!--------------->
							<p>
                                <label for="moip_emanalise">Situação Em Análise:</label>
                                <select id="moip_emanalise" name="moip_emanalise">
									<?php foreach($query_status->rows as $status): ?>
									<option value="<?php echo $status['order_status_id'] ?>"><?php echo $status['name'] ?></option>
									<?php endforeach; ?>
								</select>
                            </p>
							
							<!--------------->
							<!-- Estornado -->
							<!--------------->
							<p>
                                <label for="moip_estornado">Situação Estornado:</label>
                                <select id="moip_estornado" name="moip_estornado">
									<?php foreach($query_status->rows as $status): ?>
									<option value="<?php echo $status['order_status_id'] ?>"><?php echo $status['name'] ?></option>
									<?php endforeach; ?>
								</select>
                            </p>
							
							<!--------------->
							<!-- Em Revisão-->
							<!--------------->
							<p>
                                <label for="moip_revisao">Situação Em Revisão:</label>
                                <select id="moip_revisao" name="moip_revisao">
									<?php foreach($query_status->rows as $status): ?>
									<option value="<?php echo $status['order_status_id'] ?>"><?php echo $status['name'] ?></option>
									<?php endforeach; ?>
								</select>
                            </p>
							
							<!--------------->
							<!--Reembolsado-->
							<!--------------->
							<p>
                                <label for="moip_reembolsado">Situação Reembolsado:</label>
                                <select id="moip_reembolsado" name="moip_reembolsado">
									<?php foreach($query_status->rows as $status): ?>
									<option value="<?php echo $status['order_status_id'] ?>"><?php echo $status['name'] ?></option>
									<?php endforeach; ?>
								</select>
                            </p>
                        </fieldset>
						
						<!---------------->
						<!-- Área/Ordem -->
						<!---------------->
                        <fieldset class="step">
                            <legend>Área e Zona Geográfica</legend>
							
							<!--------------->
							<!--    Zona   -->
							<!--------------->
                            <p>
                                <label for="moip_geo_zone_id">Zona Geográfica:</label>
                                <select id="moip_geo_zone_id" name="moip_geo_zone_id">
                                    <option value="0">Todas as Zonas</option>
									<?php foreach ($query_zone->rows as $zone): ?>
                                    <option value="<?php echo $zone['geo_zone_id'] ?>"><?php echo $zone['name'] ?></option>
									<?php endforeach; ?>
                                </select>
                            </p>
							
							<!--------------->
							<!--   Ordem   -->
							<!--------------->
                            <p>
                                <label for="moip_sort_order">Ordem:</label>
                                <input id="moip_sort_order" name="moip_sort_order" type="number" AUTOCOMPLETE=OFF />
                            </p>
                        </fieldset>
						
						<!-------------->
						<!-- Parcelas -->
						<!-------------->
                        <fieldset class="step">
							<legend>Paracelas</legend>
                            <table class="list" id="parcelas">
								<!----------------->
								<!--  Cabeçalho  -->
								<!----------------->
								<thead>
									<tr>
										<td class="left">De</td>
										<td class="left">Para</td>
										<td class="left">Juros</td>
										<td></td>
									</tr>
								</thead>
								<tbody id="module-row0">
									
									<!----------------->
									<!--      De     -->
									<!----------------->
									<tr>
										<td class="left">
											<select name="moip_parcelas[0][de]">
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
												<option value="6">6</option>
												<option value="7">7</option>
												<option value="8">8</option>
												<option value="9">9</option>
												<option value="10">10</option>
												<option value="11">11</option>
												<option value="12">12</option>
											</select>
										</td>
										
										<!----------------->
										<!--     Para    -->
										<!----------------->
										<td class="right">
											<select name="moip_parcelas[0][para]">
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
												<option value="6">6</option>
												<option value="7">7</option>
												<option value="8">8</option>
												<option value="9">9</option>
												<option value="10">10</option>
												<option value="11">11</option>
												<option value="12">12</option>
											</select>
										</td>
										
										<!----------------->
										<!--    Juros    -->
										<!----------------->
										<td class="right">
											<input type="text" value="" name="moip_parcelas[0][juros]" title="Juros" />
										</td>
										<td class="left"><a onclick="$('#module-row0').remove();" class="button">Remover</a></td>
									</tr>
								</tbody>
								<tfoot>
									
									<!----------------->
									<!-- Add Parcela -->
									<!----------------->
									<tr>
										<td colspan="3"></td>
										<td class="left"><a onclick="addParcela();" class="button">Adicionar</a></td>
									</tr>
								</tfoot>
							</table>
                        </fieldset>
						
						<!-------------->
						<!--   Boleto -->
						<!-------------->
						<fieldset class="step">
							<legend>Boleto</legend>
							<!--------------->
							<!--   Prazo   -->
							<!--------------->
                            <p>
                                <label for="moip_diasCorridosBoleto">Prazo:</label>
                                <input id="moip_diasCorridosBoleto" name="moip_diasCorridosBoleto" type="number" AUTOCOMPLETE=OFF />
                            </p>
							
							<!--------------->
							<!--Instrução1 -->
							<!--------------->
							<p>
                                <label for="moip_instrucaoUmBoleto">Instrução 1:</label>
                                <input id="moip_instrucaoUmBoleto" name="moip_instrucaoUmBoleto" type="text" AUTOCOMPLETE=OFF />
                            </p>
							
							<!--------------->
							<!--Instrução2 -->
							<!--------------->
							<p>
                                <label for="moip_instrucaoDoisBoleto">Instrução 2:</label>
                                <input id="moip_instrucaoDoisBoleto" name="moip_instrucaoDoisBoleto" type="text" AUTOCOMPLETE=OFF />
                            </p>
							
							<!--------------->
							<!--Instrução3 -->
							<!--------------->
							<p>
                                <label for="moip_instrucaoTresBoleto">Instrução 3:</label>
                                <input id="moip_instrucaoTresBoleto" name="moip_instrucaoTresBoleto" type="text" AUTOCOMPLETE=OFF />
                            </p>
							
							<!--------------->
							<!--  Url Logo -->
							<!--------------->
							<p>
                                <label for="moip_urlLogoBoleto">Url de sua logo::</label>
                                <input id="moip_urlLogoBoleto" name="moip_urlLogoBoleto" type="url" AUTOCOMPLETE=OFF />
                            </p>
							
                        </fieldset>
						
						<!-------------->
						<!--Formas Pag-->
						<!-------------->
						<fieldset class="step">
							<legend>Formas de Pagamento</legend>
							<!--------------->
							<!--  Credito  -->
							<!--------------->
                            <p>
                                <label for="moip_accCartaoCredito">Aceitar Cartão de Crédito?</label>
								<select id="moip_accCartaoCredito" name="moip_accCartaoCredito">
									<option value="1">Sim</option>
									<option value="0">Não</option>
								</select>
                            </p>
							
							<!--------------->
							<!--   Boleto  -->
							<!--------------->
							<p>
                                <label for="moip_accBoleto">Aceitar Boleto Bancário?</label>
								<select id="moip_accBoleto" name="moip_accBoleto">
									<option value="1">Sim</option>
									<option value="0">Não</option>
								</select>
                            </p>
							
							<!--------------->
							<!--   Débito  -->
							<!--------------->
							<p>
                                <label for="moip_accDebito">Aceitar Débito?</label>
								<select id="moip_accDebito" name="moip_accDebito">
									<option value="1">Sim</option>
									<option value="0">Não</option>
								</select>
                            </p>
							
							<!--------------->
							<!-- Finalizar -->
							<!--------------->
							<p>
                                <button type="submit">Concluir</button>
                            </p>
                        </fieldset>
                    </form>
                </div>
                <div id="navigation" style="display:none;">
                    <ul>
                        <li class="selected">
                            <a href="#">Configurações</a>
                        </li>
                        <li>
                            <a href="#">Status de Pagamento</a>
                        </li>
                        <li>
                            <a href="#">Área e Ordem</a>
                        </li>
                        <li>
                            <a href="#">Parcelas</a>
                        </li>
						<li>
                            <a href="#">Boleto</a>
                        </li>
						<li>
                            <a href="#">Formas de Pagamento</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
		<small>Autor do Formulário: <a href="http://tympanus.net/codrops/">Codrops</a></small>
    </body>
	<script><!--
		var module_row = 1;
		
		$('select[name="moip_pagadorTaxa"]').change(function (){
			if ($(this).val() == 'afiliado') {
				$('input[name="moip_loginMoip"]').hide();
			}else{
				$('input[name="moip_loginMoip"]').show();
			}
		});
		
		function addParcela() {
			
			html  = '<tbody id="module-row'+module_row+'">'
			html += '	<tr>'
			html += '		<td class="left">'
			html += '			<select name="moip_parcelas[\''+module_row+'\'][de]">'
			html += '				<option value="2">2</option>'
			html += '				<option value="3">3</option>'
			html += '				<option value="4">4</option>'
			html += '				<option value="5">5</option>'
			html += '				<option value="6">6</option>'
			html += '				<option value="7">7</option>'
			html += '				<option value="8">8</option>'
			html += '				<option value="9">9</option>'
			html += '				<option value="10">10</option>'
			html += '				<option value="11">11</option>'
			html += '				<option value="12">12</option>'
			html += '			</select>'
			html += '		</td>'
			html += '		<td class="right">'
			html += '			<select name="moip_parcelas[\''+module_row+'\'][para]">'
			html += '				<option value="2">2</option>'
			html += '				<option value="3">3</option>'
			html += '				<option value="4">4</option>'
			html += '				<option value="5">5</option>'
			html += '				<option value="6">6</option>'
			html += '				<option value="7">7</option>'
			html += '				<option value="8">8</option>'
			html += '				<option value="9">9</option>'
			html += '				<option value="10">10</option>'
			html += '				<option value="11">11</option>'
			html += '				<option value="12">12</option>'
			html += '			</select>'
			html += '		</td>'
			html += '		<td class="right">'
			html += '			<input type="text" value="000" name="moip_parcelas[\''+module_row+'\'][juros]" title="Juros" />'
			html += '		</td>'
			html += '		<td class="left"><a onclick="$(\'#module-row'+module_row+'\').remove();" class="button">Remover</a></td>'
			html += '	</tr>'
			html += '</tbody>'
			
			module_row++;
			
			$('#parcelas tfoot').before(html);
		};
	//--></script>
</html>