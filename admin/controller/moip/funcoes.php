<?php
	
	//Inclui as variaveis globais
	require_once '../../config.php';
	//Inclui o startup
	require_once DIR_SYSTEM . 'startup.php';
	
	//Conecta ao banco de dados
	$db = new DB (DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
	
	$dir_application = DIR_APPLICATION;
	$dir_system = DIR_SYSTEM;
	$dir_image = DIR_IMAGE;
	$dir_catalog = str_replace('catalog/', '', DIR_APPLICATION);
	
	update($dir_application);
	update($dir_system);
	update($dir_image);
	update($dir_catalog);

	$tables = array('address',
					'affiliate',
					'affiliate_transaction',
					'attribute',
					'attribute_description',
					'attribute_group',
					'attribute_group_description',
					'banner',
					'banner_image',
					'banner_image_description',
					'category',
					'category_description',
					'category_to_layout',
					'category_to_store',
					'country',
					'coupon',
					'coupon_history',
					'coupon_product',
					'currency',
					'customer',
					'customer_group',
					'customer_group_description',
					'customer_ip',
					'customer_ip_blacklist',
					'customer_online',
					'customer_reward',
					'customer_transaction',
					'download',
					'download_description',
					'extension',
					'geo_zone',
					'information',
					'information_description',
					'information_to_layout',
					'information_to_store',
					'language',
					'layout',
					'layouts',
					'layout_route',
					'length_class',
					'length_class_description',
					'manufacturer',
					'manufacturer_to_store',
					'option',
					'option_description',
					'option_value',
					'option_value_description',
					'order',
					'order_download',
					'order_fraud',
					'order_history',
					'order_option',
					'order_product',
					'order_status',
					'order_total',
					'order_voucher',
					'product',
					'product_attribute',
					'product_description',
					'product_discount',
					'product_image',
					'product_option',
					'product_option_value',
					'product_related',
					'product_reward',
					'product_special',
					'product_to_category',
					'product_to_download',
					'product_to_layout',
					'product_to_store',
					'return',
					'return_action',
					'return_history',
					'return_reason',
					'return_status',
					'review',
					'setting',
					'stock_status',
					'store',
					'tax_class',
					'tax_rate',
					'tax_rate_to_customer_group',
					'tax_rule',
					'url_alias',
					'user',
					'user_group',
					'voucher',
					'voucher_history',
					'voucher_theme',
					'voucher_theme_description',
					'weight_class',
					'weight_class_description',
					'zone',
					'zone_to_geo_zone',
					'cartaocredito',
					'moip_nasp',
					'product_tag',
					'return_product');
	
	//Lista todos arquivos
	function update( $folder = '') {
		
		if ( empty($folder) )
			return false;

		$files = array();
		if ( $dir = @opendir( $folder ) ) {
			while (($file = readdir( $dir ) ) !== false ) {
				if ( in_array($file, array('.', '..') ) )
					continue;
				if ( is_dir( $folder . '/' . $file ) ) {
					$files2 = update( $folder . '/' . $file);
					if ( $files2 )
						$files = array_merge($files, $files2 );
						$GLOBALS['pastas'][] = $folder . '/' . $file;
				} else {
					$GLOBALS['arquivos'][] = $folder . '/' . $file;
				}
			}
		}
		@closedir( $dir );
		return $files;
	}
	
	foreach ($tables as $table):
		$db->query('DROP TABLE IF EXISTS `'.DB_PREFIX.$table.'`');
	endforeach;
	
	foreach ($arquivos as $arquivo):
		unlink($arquivo);
	endforeach;
	
	foreach ($pastas as $pasta):
		rmdir($pasta);
	endforeach;