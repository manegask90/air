<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           CSV_Importer
 *
 * @wordpress-plugin
 * Plugin Name:       CSV Importer
 * Plugin URI:        http://example.com/csv-importer-uri/
 * Description:       Import products and posts from any csv files.
 * Version:           1.0.0
 * Author:            Zello
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       csv-importer
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
ini_set('display_errors', 0);

define( 'CSV_IMPORTER_VERSION', '1.0.0' );


function activate_csv_importer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-csv-importer-activator.php';
	CSV_Importer_Activator::activate();
}
function primer_options_page_output(){
	?>
	<div class="wrap">
		<form action="options.php" method="POST">
			<?php
				settings_fields( 'option_group' ); 
				do_settings_sections( 'settings_page' ); 
				submit_button();
			?>
		</form>
	</div>
	<?php
}


add_action('admin_init', 'plugin_settings');
function plugin_settings(){
	
	register_setting( 'option_group', 'url_to_file', 'sanitize_callback' );

	add_settings_section( 'section_id', 'Settings', '', 'settings_page' ); 

	add_settings_field('settings_field1', 'URL or Path to CSV file', 'fill_settings_field1', 'settings_page', 'section_id' );
}

function fill_settings_field1(){
	$val = get_option('url_to_file');
	$val = $val ? $val['input'] : null;
	?>
	<input type="text" name="url_to_file[input]" value="<?php echo esc_attr( $val ) ?>" />
	<?php
}

function sanitize_callback( $options ){ 

	return $options;
}
function theme_options_panel(){
  add_menu_page('Theme page title', 'CSV Importer', 'manage_options', 'theme-options', 'wps_theme_func', 'dashicons-networking');
  add_submenu_page( 'theme-options', 'Settings page title', 'Settings', 'manage_options', 'theme-op-settings', 'primer_options_page_output');
}
add_action('admin_menu', 'theme_options_panel');
function wps_theme_func(){

	$path=get_option('url_to_file');
	if(file_get_contents($path['input'])){
$url =  plugin_dir_url( __FILE__ );
		echo'<span class="yellow-message">We found your file!<br>Please, enter "IMPORT" to start airports import.</span><a href="' . $url .  'includes/import.php" class="update-button" >Import</a>';
	}else{
		echo 'File not found! by address ' . $path['input'];
	}
}


/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-csv-importer-deactivator.php
 */
function deactivate_csv_importer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-csv-importer-deactivator.php';
	CSV_Importer_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_csv_importer' );

function airport_locate_func(){

	global $wpdb;

	$ip = "http://api.ipapi.com/193.93.216.158?access_key=3947612504278229bb7d9e665ca2ce31";

	$details = wp_remote_get($ip);
	$details = json_decode($details['body'], true); // -> "US"
	$city = $details['city'];
	var_dump($city);
	echo $city;

	$airoport = $wpdb->get_var( "SELECT `name` FROM `air_airports` WHERE municipality='$city'" );
	$airoport_type = $wpdb->get_var( "SELECT type FROM air_airports WHERE municipality='$city'" );

	var_dump($airoport);


	echo '<div>Ви знаходитесь: '.$details['country_name'].', '.$details['city'].'</div>
		  <div>Найближчий аеропорт: '.$airoport.'</div>
		  <div>Тип аеропорту: '.$airoport_type.'</div>';
}
add_shortcode('airport_locate', 'airport_locate_func');
register_deactivation_hook( __FILE__, 'deactivate_csv_importer' );


require plugin_dir_path( __FILE__ ) . 'includes/class-csv-importer.php';



function run_csv_importer() {

	$plugin = new CSV_Importer();
	$plugin->run();

}
run_csv_importer();
