<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    CSV_Importer
 * @subpackage CSV_Importer/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    CSV_Importer
 * @subpackage CSV_Importer/includes
 * @author     Zello <zelloooo1997@gmail.com>
 */
class CSV_Importer_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */

	public static function activate() {
		global $wpdb;

   		$table_name = "air_airports"; 

   		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  second_id text NOT NULL,
		  ident text NOT NULL,
		  type text NOT NULL,
		  name text NOT NULL,
		  latitude_deg text NOT NULL,
		  longitude_deg text NOT NULL,
		  elevation_ft text NOT NULL,
		  continent text NOT NULL,
		  iso_country text NOT NULL,
		  iso_region text NOT NULL,
		  municipality text NOT NULL,
		  scheduled_service text NOT NULL,
		  gps_code text NOT NULL,
		  iata_code text NOT NULL,
		  local_code text NOT NULL,
		  home_link text NOT NULL,
		  wikipedia_link text NOT NULL,
		  keywords text NOT NULL,
		  PRIMARY KEY  (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		

	}

}
