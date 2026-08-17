<?php
/**
 * Plugin Name: Sova Professional Post Grid for Elementor
 * Description: A responsive, fully customizable Elementor post grid with headline, subtitle, view-more link, thumbnails, dates, titles, and excerpts.
 * Version: 1.1.0
 * Author: Mahdi Hassani
 * Text Domain: sova-post-grid
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Elementor tested up to: 3.30
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SOVA_POST_GRID_VERSION', '1.1.0' );
define( 'SOVA_POST_GRID_FILE', __FILE__ );
define( 'SOVA_POST_GRID_PATH', plugin_dir_path( __FILE__ ) );
define( 'SOVA_POST_GRID_URL', plugin_dir_url( __FILE__ ) );

final class Sova_Post_Grid_Plugin {
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	public function init() {
		load_plugin_textdomain( 'sova-post-grid', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'elementor_missing_notice' ) );
			return;
		}

		add_action( 'elementor/frontend/after_register_styles', array( $this, 'register_styles' ) );
		add_action( 'elementor/widgets/register', array( $this, 'register_widget' ) );
	}

	public function register_styles() {
		wp_register_style(
			'sova-post-grid',
			SOVA_POST_GRID_URL . 'assets/css/widget.css',
			array(),
			SOVA_POST_GRID_VERSION
		);
	}

	public function register_widget( $widgets_manager ) {
		require_once SOVA_POST_GRID_PATH . 'includes/class-sova-post-grid-widget.php';
		$widgets_manager->register( new \Sova_Post_Grid_Widget() );
	}

	public function elementor_missing_notice() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		echo '<div class="notice notice-warning"><p>';
		echo esc_html__( 'Sova Professional Post Grid requires Elementor to be installed and activated.', 'sova-post-grid' );
		echo '</p></div>';
	}
}

new Sova_Post_Grid_Plugin();
