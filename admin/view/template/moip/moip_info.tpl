<?php echo $header ?>
	<div id="content">

		<!------------------->
		<!--  Breadcrumb   -->
		<!------------------->
		<div class="breadcrumb">
			<?php foreach ($breadcrumbs as $breadcrumb) { ?>
			<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
			<?php } ?>
		</div>
		
		<!------------------->
		<!--    Content    -->
		<!------------------->
		<div class="box">
			
			<div class="heading">
				<h1><img src="view/image/order.png" alt="" />Detalhes do Pedido #<?php echo $data_order['order_id'] ?></h1>
				<div class="buttons">
					<a href="<?php echo $link_order_update; ?>" class="button">Atualizar Pedido</a>
					<a href="<?php echo $link_cancel; ?>" class="button">Cancelar</a>
				</div>
			</div>
			
			<!------------------->
			<!-- Content Order -->
			<!------------------->
			<div class="content">
				<!------------------->
				<!--     Tabs      -->
				<!------------------->
				<div id="vtabs" class="vtabs">
					<a href="#detalhesPedido">Detalhes do Pedido</a>
					<a href="#detalhesPagamento">Detalhes do Pagamento</a>
					<a href="#detalhesFrete">Detalhes do Frete</a>
					<a href="#detalhesProduto">Detalhes dos Produtos</a>
					<a href="#historicoPedido">Histórico do Pedido</a>
					<a href="#detalhesMoip">Detalhes MoIP</a>
				</div>
				
				<!------------------->
				<!--Content of Tabs-->
				<!------------------->
				<div class="vtabs-content">
					
					<!------------------->
					<!--   Data Order  -->
					<!------------------->
					<div id="detalhesPedido">
						<table class="form">
							<tr>
								<td class="left">Pedido Nº:</td>
								<td class="left">#<?php echo $data_order['order_id'] ?></td>
							</tr>
							<tr>
								<td class="left">Fatura Nº:</td>
								<td class="left"><?php echo $data_order['invoice_prefix'] ?></td>
							</tr>
							<tr>
								<td class="left">Loja:</td>
								<td class="left"><?php echo $data_order['store_name'] ?></td>
							</tr>
							<tr>
								<td class="left">URL da Loja:</td>
								<td class="left"><?php echo $data_order['store_url'] ?></td>
							</tr>
							<tr>
								<td class="left">Cliente:</td>
								<td class="left"><?php echo $data_order['firstname'].' '.$data_order['lastname'] ?></td>
							</tr>
							<tr>
								<td class="left">Grupo do Cliente:</td>
								<td class="left"><?php echo $data_order['customer_group_name']['name'] ?></td>
							</tr>
							<tr>
								<td class="left">E-mail:</td>
								<td class="left"><?php echo $data_order['email'] ?></td>
							</tr>
							<tr>
								<td class="left">Telefone:</td>
								<td class="left"><?php echo $data_order['telephone'] ?></td>
							</tr>
							<tr>
								<td class="left">Total Original do Pedido:</td>
								<td class="left"><?php echo $data_order['total'] ?></td>
							</tr>
							<tr>
								<td class="left">Situação do Pedido:</td>
								<td class="left"><?php echo $data_order['order_status_name'][0]['name'] ?></td>
							</tr>
							<?php if ($data_order['affiliate_id'] == 1): ?>
							<tr>
								<td class="left">Afiliado:</td>
								<td class="left"><?php echo $data_order['affiliate_firstname'].' '.$data_order['affiliate_lastname'] ?></td>
							</tr>
							<tr>
								<td class="left">Comissão:</td>
								<td class="left"><?php echo $data_order['commission'] ?></td>
							</tr>
							<?php endif; ?>
							<tr>
								<td class="left">Endereço IP:</td>
								<td class="left"><?php echo $data_order['ip'] ?></td>
							</tr>
							<tr>
								<td class="left">Agente do Usuário:</td>
								<td class="left"><?php echo $data_order['user_agent'] ?></td>
							</tr>
							<tr>
								<td class="left">Accept Language:</td>
								<td class="left"><?php echo $data_order['accept_language'] ?></td>
							</tr>
							<tr>
								<td class="left">Data da Criação:</td>
								<td class="left"><?php echo $data_order['date_added'] ?></td>
							</tr>
							<tr>
								<td class="left">Última Modificação:</td>
								<td class="left"><?php echo $data_order['date_modified'] ?></td>
							</tr>
						</table>
					</div>
					
					<!------------------->
					<!-- Data Payment  -->
					<!------------------->
					<div id="detalhesPagamento">
						<table class="form">
							<tr>
								<td class="left">Nome:</td>
								<td class="left"><?php echo $data_order['payment_firstname'] ?></td>
							</tr>
							<tr>
								<td class="left">Sobrenome:</td>
								<td class="left"><?php echo $data_order['payment_lastname'] ?></td>
							</tr>
							<tr>
								<td class="left">Endereço, número:</td>
								<td class="left"><?php echo $data_order['payment_address_1'] ?></td>
							</tr>
							<tr>
								<td class="left">Cidade:</td>
								<td class="left"><?php echo $data_order['payment_city'] ?></td>
							</tr>
							<tr>
								<td class="left">CEP:</td>
								<td class="left"><?php echo $data_order['payment_postcode'] ?></td>
							</tr>
							<tr>
								<td class="left">Estado:</td>
								<td class="left"><?php echo $data_order['payment_zone'] ?></td>
							</tr>
							<tr>
								<td class="left">Sigla do Estado:</td>
								<td class="left"><?php echo $data_order['payment_zone_code'] ?></td>
							</tr>
							<tr>
								<td class="left">País:</td>
								<td class="left"><?php echo $data_order['payment_country'] ?></td>
							</tr>
							<tr>
								<td class="left">Método de Pagamento:</td>
								<td class="left"><?php echo $data_order['payment_method'] ?></td>
							</tr>
						</table>
					</div>
					
					<!------------------->
					<!-- Data Shipping -->
					<!------------------->
					<div id="detalhesFrete">
						<table class="form">
							<tr>
								<td class="left">Nome:</td>
								<td class="left"><?php echo $data_order['shipping_firstname'] ?></td>
							</tr>
							<tr>
								<td class="left">Sobrenome:</td>
								<td class="left"><?php echo $data_order['shipping_lastname'] ?></td>
							</tr>
							<tr>
								<td class="left">Endereço, número:</td>
								<td class="left"><?php echo $data_order['shipping_address_1'] ?></td>
							</tr>
							<tr>
								<td class="left">Cidade:</td>
								<td class="left"><?php echo $data_order['shipping_city'] ?></td>
							</tr>
							<tr>
								<td class="left">CEP:</td>
								<td class="left"><?php echo $data_order['shipping_postcode'] ?></td>
							</tr>
							<tr>
								<td class="left">Estado:</td>
								<td class="left"><?php echo $data_order['shipping_zone'] ?></td>
							</tr>
							<tr>
								<td class="left">Sigla do Estado:</td>
								<td class="left"><?php echo $data_order['shipping_zone_code'] ?></td>
							</tr>
							<tr>
								<td class="left">País:</td>
								<td class="left"><?php echo $data_order['shipping_country'] ?></td>
							</tr>
							<tr>
								<td class="left">Método de Envio:</td>
								<td class="left"><?php echo $data_order['shipping_method'] ?></td>
							</tr>
						</table>
					</div>
					
					<!------------------->
					<!-- Data Product  -->
					<!------------------->
					<div id="detalhesProduto">
						<br/>
						<table class="list">
							<thead>
								<tr>
									<td class="left">Produto</td>
									<td class="left">Modelo</td>
									<td class="right">Quantidade</td>
									<td class="right">Unitário</td>
									<td class="right">Total</td>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($data_products as $data_product): ?>
								<tr>
									<td class="left"><?php echo $data_product['name'] ?></td>
									<td class="left"><?php echo $data_product['model'] ?></td>
									<td class="right"><?php echo $data_product['quantity'] ?></td>
									<td class="right"><?php echo $data_product['price'] ?></td>
									<td class="right"><?php echo $data_product['total'] ?></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
							<tfoot>
								<?php foreach ($totals_order as $total): ?>
								<tr>
									<td colspan="4" class="right"><?php echo $total['title'] ?></td>
									<td class="right"><?php echo $total['text'] ?></td>
								</tr>
								<?php endforeach; ?>
							</tfoot>
						</table>
					</div>
					
					<!------------------->
					<!-- History Order -->
					<!------------------->
					<div id="historicoPedido">
						<br/>
						<table class="list">
							<thead>
								<tr>
									<td class="left">Data da Criação</td>
									<td class="left">Comentário</td>
									<td class="left">Situação</td>
									<td class="left">Cliente Notificado</td>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($histories_order as $history_order): ?>
								<tr>
									<td class="left"><?php echo $history_order['date_added'] ?></td>
									<td class="left"><?php echo $history_order['comment'] ?></td>
									<td class="left"><?php echo $history_order['status'] ?></td>
									<td class="left"><?php echo $history_order['notify'] ?></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					
					<!------------------->
					<!--  Order MoIP   -->
					<!------------------->
					<div id="detalhesMoip">
						<table class="form">
							<tr>
								<td>Transação Nº:</td>
								<td>#<?php echo $moip_order['id_transacao'] ?></td>
							</tr>
							<tr>
								<td>Valor:</td>
								<td><?php echo $moip_order['valor'] ?></td>
							</tr>
							<tr>
								<td>Status de Pagamento:</td>
								<td><?php echo $moip_order['status_pagamento'] ?></td>
							</tr>
							<tr>
								<td>Cod Moip:</td>
								<td><?php echo $moip_order['cod_moip'] ?></td>
							</tr>
							<tr>
								<td>Forma de Pagamento:</td>
								<td><?php echo $moip_order['forma_pagamento'] ?></td>
							</tr>
							<tr>
								<td>Tipo de Pagamento:</td>
								<td><?php echo $moip_order['tipo_pagamento'] ?></td>
							</tr>
							<tr>
								<td>Parcelas:</td>
								<td><?php echo $moip_order['parcelas'] ?></td>
							</tr>
							<?php if ($moip_order['tipo_pagamento'] == 'CartaoDeCredito'): ?>
							<tr>
								<td>Nº Cartão:</td>
								<td><?php echo $moip_order['num_cartao'] ?></td>
							</tr>
							<?php endif; ?>
							<?php if ($moip_order['tipo_pagamento'] == 'CartaoDeCredito'): ?>
							<tr>
								<td>Bandeira do Cartão:</td>
								<td><?php echo $moip_order['cartao_bandeira'] ?></td>
							</tr>
							<?php endif; ?>
							<?php if ($moip_order['tipo_pagamento'] == 'CartaoDeCredito'): ?>
							<tr>
								<td>Cofre:</td>
								<td><?php echo $moip_order['cofre'] ?></td>
							</tr>
							<?php endif; ?>
						</table>
					</div>
				</div>
			</div>
		
			<!------------------->
			<!--   Copyright   -->
			<!------------------->
			<small>Desenvolvido por: <a href="mailto:valdeirpsr@hotmail.com.br">Valdeir Santana</a></small>
		</div>
	</div>
	
<script><!--
	$('.vtabs a').tabs();
//--></script>
<?php echo $footer ?>
