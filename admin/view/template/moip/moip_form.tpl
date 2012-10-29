<?php echo $header; ?>
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
	
		<!------------------->
		<!--     Title     -->
		<!------------------->
		<div class="heading">
		  <h1><img src="view/image/order.png" alt="" /><?php echo $heading_title; ?></h1>
		</div>
		
		<!------------------->
		<!--  Table Info   -->
		<!------------------->
		<div class="content">
			<table class="list">
			
				<!------------------->
				<!--  Title Table  -->
				<!------------------->
				<thead>
					<tr>
						<td class="right">Order ID</td>
						<td class="right">Customer</td>
						<td class="right">Status</td>
						<td class="right">Total</td>
						<td class="right">Date Added</td>
						<td class="right">Date Modification</td>
						<td class="right">Action</td>
					</tr>
				</thead>
				<tbody>
				
					<!------------------->
					<!--     Filter    -->
					<!------------------->
					<tr class="filter">
						<td class="right"><input name="filter_order_id" type="text" size="3" value="<?php echo $filter_order_id ?>" /></td>
						<td class="right"><input name="filter_customer" type="text" value="<?php echo $filter_customer ?>" /></td>
						<td class="right">
							<select name="filter_status">
								<option value="-1"></option>
								<?php foreach ($order_statuses as $status) { ?>
								<?php if ($status['order_status_id'] == $filter_status): ?>
								<option value="<?php echo $status['order_status_id'] ?>" selected="selected"><?php echo $status['name'] ?></option>
								<?php else: ?>
								<option value="<?php echo $status['order_status_id'] ?>"><?php echo $status['name'] ?></option>
								<?php endif; ?>
								<?php } ?>
							</select>
						</td>
						<td class="right"><input name="filter_total" type="text" size="4" value="<?php echo $filter_total ?>" /></td>
						<td class="right"><input name="filter_date_added" type="text" size="12" class="date" value="<?php echo $filter_date_added ?>" /></td>
						<td class="right"><input name="filter_date_modified" type="text" size="12" class="date" value="<?php echo $filter_date_modified ?>" /></td>
						<td class="right"><a onClick="filter()" class="button"><span>Filter</span></a></td>
					</tr>
					
					<!------------------->
					<!--     Orders    -->
					<!------------------->
					<?php if (!empty($orders)){ ?>
						<?php foreach ($orders as $order) { ?>
						<tr>
							<td class="right"><?php echo $order['order_id'] ?></td>
							<td class="right"><?php echo $order['customer'] ?></td>
							<td class="right"><?php echo $order['status'] ?></td>
							<td class="right"><?php echo $order['total'] ?></td>
							<td class="right"><?php echo $order['date_added'] ?></td>
							<td class="right"><?php echo $order['date_modified'] ?></td>
							<td class="right">
								<?php foreach ($order['action'] as $action) { ?>
								<a href="<?php echo $action['href'] ?>">[ <?php echo $action['text'] ?> ]</a>
								<?php } ?>
							</td>
						</tr>
						<?php } ?>
					<?php }else{ ?>
						<tr>
							<td colspan="7" class="center">Nenhum resultado encontrado.</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			
			<!------------------->
			<!--   Pagination  -->
			<!------------------->
			<div class="pagination">
				<?php echo $pagination ?>
			</div>
		</div>
		
		<!------------------->
		<!--   Copyright   -->
		<!------------------->
		<small>Desenvolvido por: <a href="mailto:valdeirpsr@hotmail.com.br">Valdeir Santana</a></small>
	</div>
</div>
<script><!--

	$('.date').datepicker({dateFormat: 'yy-mm-dd'});
	
	function filter()	{
		var url = 'index.php?route=moip/moip&token=<?php echo $this->session->data['token']; ?>';
		
		
		var filter_order_id = $('input[name="filter_order_id"]').val();
		if (filter_order_id) {
			url += '&filter_order_id=' + encodeURIComponent(filter_order_id);
		}
		
		var filter_customer = $('input[name="filter_customer"]').val();
		if (filter_customer) {
			url += '&filter_customer=' + encodeURIComponent(filter_customer);
		}
		
		var filter_status = $('select[name="filter_status"]').attr('value');
		if (filter_status != '-1') {
			url += '&filter_order_status_id=' + encodeURIComponent(filter_status);
		}
		
		var filter_total = $('input[name="filter_total"]').val();
		if (filter_total) {
			url += '&filter_total=' + encodeURIComponent(filter_total);
		}
		
		var filter_date_added = $('input[name="filter_date_added"]').val();
		if (filter_date_added) {
			url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
		}
		
		var filter_date_modified = $('input[name="filter_date_modified"]').val();
		if (filter_date_modified) {
			url += '&filter_date_modified=' + encodeURIComponent(filter_date_modified);
		}
		
		location = url;
		
	}
//--></script>
<?php echo $footer; ?>