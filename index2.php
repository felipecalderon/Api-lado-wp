<?php 

require __DIR__ . '/vendor/autoload.php';

	use Automattic\WooCommerce\Client;
		$woocommerce = new Client(
		    'https://dmkt.cl/', 
		    'ck_e450a0e42f8868722bbee9bfce62c795a66c35c9', 
		    'cs_945ff225c5c2b49a60023b0c81c2f021326980e3',
		    [
		        'version' => 'wc/v3',
		        'verify_ssl'=> false,
		    ]
		);

	$usuario = 'asdkjdajklasdk123kl';
	$clave = 'cklasdkfsd121321';
	$url = 'http://localhost/api-cliente/api/post/read.php';

	 
	$context = stream_context_create(array(
	    'http' => array(
	        'header'  => "Authorization: Basic " . base64_encode("$usuario:$clave")
	    )
	));

	$datitos = file_get_contents($url, false, $context);
	$json_todos = json_decode($datitos, true);
	$conteo_totales  = count($json_todos);

	function Tomadedatos($array) {
		$url2 = 'http://localhost/api-cliente/api/post/read_single.php';
  		$productos_cliente = array();

		foreach($array as $datos) {

			      $productos_cliente[] = array(
			      			'id' 				=>	$datos['id'],
			         		'regular_price' 	=> 	$datos['precio'],
							'stock_quantity'   	=> 	$datos['stock']
			      );

					$id_cliente = $datos['id'];
					$json = file_get_contents('http://localhost/api-cliente/api/post/read_single.php?id='.$id_cliente,false,stream_context_create(array(
						'http' => array(
	        				'header'  => "Authorization: Basic " . base64_encode("asdkjdajklasdk123kl:cklasdkfsd121321")))));
					
					$datos_subida = json_decode($json,true);
					$precio_cliente = $datos['precio'];
					$stock_cliente = $datos['stock'];
			      	
						$datos_puja = [
							'regular_price' => $datos['precio'],
							'manage_stock'   => 'true',
							'in_stock'         => 'true',
							'stock_quantity'   => $datos['stock']
						];
					$woocommerce2 = new Client(
					    'https://dmkt.cl/', 
					    'ck_e450a0e42f8868722bbee9bfce62c795a66c35c9', 
					    'cs_945ff225c5c2b49a60023b0c81c2f021326980e3',
					    [
					        'version' => 'wc/v3',
					        'verify_ssl'=> false,
					    ]
					);

					echo '<pre>';
			      	//print_r($datos_puja);
			      	print_r($woocommerce2->put('products/'.$id_cliente, $datos_puja));
			      	echo '</pre>';

			  }
			  return $productos_cliente;
			}

			$datos_subida = [
			   'arreglo' => Tomadedatos($json_todos)
			];

		//print_r($woocommerce->post('products/batch', $datos_subida));


/* OBSOLETO 

	$id = '264';
	$json = file_get_contents('http://localhost/api-cliente/api/post/read_single.php?id='.$id);
	$datos = json_decode($json,true);

	$id_cliente = $datos['id'];
	$precio_cliente = $datos['precio'];
	$stock_cliente = $datos['stock'];


	$datos_puja = [
		'regular_price' => $datos['precio'],
		'manage_stock'   => 'true',
		'in_stock'         => 'true',
		'stock_quantity'   => $datos['stock']
	];

	print_r($woocommerce->put('products/'.$id, $datos_puja));

*/

