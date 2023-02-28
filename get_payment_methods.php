<?php
require __DIR__ . '/utilities.php';
require __DIR__ . '/vendor/autoload.php';

// Get Payment Methods by Country Function
function get_payment_methods_by_country($country_code) {
	$method = 'get';
	$path = '/v1/payment_methods/country?country=' . $country_code;

	// Make the API request
	try {
		return $result = make_request($method, $path);
	} catch(Exception $e) {
		return 'Message: ' .$e->getMessage();
	}
}


// Generate HTML
function generate_payment_methods_html($country_code) {
	$payment_methods = get_payment_methods_by_country($country_code);

	if($payment_methods['data']) {
		// Create the HTML Head
		echo '<!DOCTYPE html>
		<html>
		<head>
		<title>Payment Methods by Country</title>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
		</head>
		<body>';

		echo '<div class="row">';
		echo '<div class="col-md-2"></div>';
		echo '<div class="col-md-8">';

		echo '<h2>Available Payment Methods</h2>';
		echo '<table class="table table-bordered table-striped">';
		echo '<tr>';
		echo '<th>Name</th>';
		echo '<th>Type</th>';
		echo '<th>Currencies</th>';
		echo '</tr>';

		// Loop The Response
		foreach ($payment_methods['data'] as $key => $value) {
			echo '<tr>';
			echo '<td>'. $value['name'] .'</td>';
			echo '<td>'. $value['type'] .'</td>';
			echo '<td>'. implode(" ", $value['currencies']) .'</td>';
			echo '</tr>';
		}

		echo '</table>';

		// Print the Response data array
		echo '<h2>Response Data</h2>';
		echo '<code>';
		var_dump($payment_methods['data']);
		echo '</code>';

		echo '</div>';
		echo '<div class="col-md-2"></div>';
		echo '</div>';
		echo '</body>';


	}
	else {
		echo $payment_methods;
	}
}


// Get Available Payment Methods in the UK
generate_payment_methods_html('GB');