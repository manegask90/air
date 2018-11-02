<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    CSV_Importer
 * @subpackage CSV_Importer/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    CSV_Importer
 * @subpackage CSV_Importer/public
 * @author     Zello <zelloooo1997@gmail.com>
 */
class CSV_Importer_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $csv_importer    The ID of this plugin.
	 */
	private $csv_importer;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $csv_importer       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $csv_importer, $version ) {

		$this->csv_importer = $csv_importer;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in CSV_Importer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The CSV_Importer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->csv_importer, plugin_dir_url( __FILE__ ) . 'css/csv-importer-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in CSV_Importer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The CSV_Importer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->csv_importer, plugin_dir_url( __FILE__ ) . 'js/csv-importer-public.js', array( 'jquery' ), $this->version, false );

	}

}
