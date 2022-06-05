<?php

/**
 * 
 * @link       https://ladyboss.com/store
 * @since      1.0.0
 *
 * @package    Ladyboss_Variations
 * @subpackage Ladyboss_Variations/public
 */

/**
 *
 * @package    Ladyboss_Variations
 * @subpackage Ladyboss_Variations/public
 * @author     Jose Velazquez <jose@ladyboss.com>
 */
class Ladyboss_Variations_Public {

	/**
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 *
	 * @since    1.0.0
	 */
	public function register_styles() {

		wp_register_style( $this->plugin_name . '-css', plugin_dir_url( __FILE__ ) . 'css/ladyboss-variations-public.css', array(), $this->version, 'all' );

	}

	/**
	 *
	 * @since    1.0.0
	 */
	public function register_scripts() {

		wp_register_script( $this->plugin_name . '-js', plugin_dir_url( __FILE__ ) . 'js/ladyboss-variations-public.js', array( 'jquery' ), $this->version, false );
		
	}

	/**
	 * Function to display the attributes.
	 *
	 * @since    1.0.0
	 */
	public function show_attributes() {

		global $product;

		if ( is_null($product) ) { 
			return; 
		}
	
		// If not a variable product return and do nothing
		if ( ! $product->is_type( 'variable' ) ) {
			return;
		}

		// Add JS and CSS files only where we need them
		wp_enqueue_script( $this->plugin_name . '-js' );

		wp_enqueue_style( $this->plugin_name . '-css' );

		// Add custom stylesheet.php when checkbox is checked
		if ( get_option( 'checkbox-setting' ) == 'on') {
			$this->add_custom_style();
		}
		
		// Fetch available attributes
		$attributes = $this->get_available_attributes( $product );
		
		// Empty attributes return nothing
		if ( empty( $attributes ) ) {
			return;
		}

		// Show all attributes in partials/ladyboss-variations-public-display.php
		include 'partials/ladyboss-variations-public-display.php';
	}
	
	/**
 	*
 	* @param WC_Product_Variable $product
 	*
 	* @return array
 	*/
	public function get_available_attributes( $product ) {

		// Cache variable
		static $available_attributes = array();

		$product_id = $product->get_id();

		if ( isset( $available_attributes[ $product_id ] ) ) {
			return $available_attributes[ $product_id ];
		}

		$available_attributes[ $product_id ] = array();
	
		// Fetch attributes which have been used for variations
		$attributes = $product->get_variation_attributes();
	
		if ( empty( $attributes ) ) {
			return $available_attributes[ $product_id ];
		}

		foreach ( $attributes as $attribute => $values ) {

			// It will determine the correct attribute labels and also whether the attribute has a variation which is available for purchase
			$available_attribute = $this->get_available_attribute( $product, $attribute, $values );

			if ( empty( $available_attribute ) ) {
				continue;
			}

			$available_attributes[ $product_id ][] = $available_attribute;
		}

		return $available_attributes[ $product_id ];
	}

	/**
 	*
 	* @param WC_Product_Variable $product
 	* @param string              $attribute
 	* @param array               $values
 	*
 	* @return array
 	*/
	public function get_available_attribute( $product, $attribute, $values ) {
		
		$available_attribute = array(
			'slug' => $attribute,
		);

		if ( ! taxonomy_exists( $attribute ) ) {
			$available_attribute['name'] = $attribute;

			foreach ( $values as $value ) {
				$available_attribute['values'][ $value ] = array(
					'name'      => $value,
					'available' => $this->has_available_variation( $product, $attribute, $value ),
				);
			}

			return $available_attribute;
		}

		$taxonomy = get_taxonomy( $attribute );
		$labels   = get_taxonomy_labels( $taxonomy );

		$available_attribute['name']   = $labels->singular_name;
		$available_attribute['values'] = array();

		foreach ( $values as $value ) {
			$term = get_term_by( 'slug', $value, $attribute );

			if ( ! $term ) {
				continue;
			}

			$available_attribute['values'][ $value ] = array(
				'name'      => $term->name,
				'slug'      => $term->slug,
				'available' => $this->has_available_variation( $product, $attribute, $value ),
			);
		}
	
		return $available_attribute;
	}

	/**
 	* Has available variation?
 	*
 	* @param WC_Product_Variable $product
 	* @param string              $attribute
 	* @param string              $value
 	*
 	* @return bool
 	*/
	public function has_available_variation( $product, $attribute, $value ) {

		$available_variation = false;
		$attribute           = 'attribute_' . sanitize_title( $attribute );
		$variations          = $product->get_available_variations();

		if ( empty( $variations ) ) {
			return $available_variation;
		}

		foreach ( $variations as $variation ) {

			foreach ( $variation['attributes'] as $variation_attribute_name => $variation_attribute_value ) {
				if ( $attribute !== $variation_attribute_name ) {
					continue;
				}

				if ( $value !== $variation_attribute_value && ! empty( $variation_attribute_value ) ) {
					continue;
				}
				
				$available_variation = $variation['is_purchasable'] && $variation['is_in_stock'];
				break;
			}

			if ( $available_variation ) {
				break;
			}
		}

		return $available_variation;
	}

	/**
 	* Load custom css style
 	*	
 	*/
	public function add_custom_style() {

		$background_color       = get_option( 'bgc-btn' );
		$hover_color            = get_option( 'hov-btn');
		$selected_button_color  = get_option( 'selected-btn');

		$font_color             = get_option( 'text-color-btn' );
		$font_hover_color       = get_option( 'hov-text');
		$selected_font_color  	= get_option( 'selected-text');

		$css = require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/stylesheet.php';
		wp_add_inline_style( 'ladyboss-variations', $css );
	}
	
}
