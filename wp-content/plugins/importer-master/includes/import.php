<?php

//require_once( '/home/zorrro/import.com.ua/www/wp-load.php' );
//	if(!defined(ABSPATH)){
//        $pagePath = explode('/wp-content/', dirname(__FILE__));
//        var_dump($pagePath);
//        die('aaaaaaaa');
//		require_once( get_site_url() . '/wp-load.php');
//	}


define('SHORTINIT', true);

require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );
$pagePath = explode('/wp-content/', dirname(__FILE__));



	ini_set('display_errors', 'On');
	error_reporting(E_ALL);
	set_time_limit(0);
	$path = get_option('url_to_file');
	$file_path = $path['input'];
	$table_name = "air_airports";

	$file_encodings = ['cp1251','UTF-8'];
	$col_delimiter = '';
	$row_delimiter = "";


	$cont = trim( file_get_contents( $file_path ) );

	$encoded_cont = mb_convert_encoding( $cont, 'UTF-8', mb_detect_encoding($cont, $file_encodings) );

	unset( $cont );


	if( ! $row_delimiter ){
		$row_delimiter = "\r\n";
		if( false === strpos($encoded_cont, "\r\n") )
			$row_delimiter = "\n";
	}

	$lines = explode( $row_delimiter, trim($encoded_cont) );
	$lines = array_filter( $lines );
	$lines = array_map( 'trim', $lines );


	if( ! $col_delimiter ){
		$lines10 = array_slice( $lines, 0, 30 );


		foreach( $lines10 as $line ){
			if( ! strpos( $line, ',') ) $col_delimiter = ';';
			if( ! strpos( $line, ';') ) $col_delimiter = ',';

			if( $col_delimiter ) break;
		}

		if( ! $col_delimiter ){
			$delim_counts = array( ';'=>array(), ','=>array() );
			foreach( $lines10 as $line ){
				$delim_counts[','][] = substr_count( $line, ',' );
				$delim_counts[';'][] = substr_count( $line, ';' );
			}

			$delim_counts = array_map( 'array_filter', $delim_counts ); 

			$delim_counts = array_map( 'array_count_values', $delim_counts );

			$delim_counts = array_map( 'max', $delim_counts ); 

			if( $delim_counts[';'] === $delim_counts[','] )
				return array('Не удалось определить разделитель колонок.');

			$col_delimiter = array_search( max($delim_counts), $delim_counts );
		}

	}

	$data = [];
	$counts=501;
	foreach( $lines as $key => $line ){

		$data[] = str_getcsv( $line, $col_delimiter );
		unset( $lines[$key] );

	}
	for($i=1; $i<$counts; $i++){

		$rows_affected = $wpdb->insert( $table_name, array( 'second_id' => $data[$i][0], 'ident' => $data[$i][1], 'type' => $data[$i][2], 'name' => $data[$i][3], 'latitude_deg' => $data[$i][4], 'longitude_deg' => $data[$i][5], 'elevation_ft' => $data[$i][6], 'continent' => $data[$i][7], 'iso_country' => $data[$i][8], 'iso_region' => $data[$i][9], 'municipality' => $data[$i][10], 'scheduled_service' => $data[$i][11], 'gps_code' => $data[$i][12], 'iata_code' => $data[$i][13], 'local_code' => $data[$i][14], 'home_link' => $data[$i][15], 'wikipedia_link' => $data[$i][16], 'keywords' => $data[$i][17] ) );

	}

	echo 'Success! <a href="http://air-test/wp-admin/admin.php?page=theme-options">Go back.</a>'
?>
