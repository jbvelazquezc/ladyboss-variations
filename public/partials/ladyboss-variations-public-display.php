<?php

/**
 * 
 * @link       https://ladyboss.com/store
 * @since      1.0.0
 *
 * @package    Ladyboss_Variations
 * @subpackage Ladyboss_Variations/public/partials
 */
?>

<?php
    // Show all attributes
    foreach ( $attributes as $attribute ) {
		echo '<div class="lb-available-attributes">';
		echo '<p class="lb-available-attributes__title"><strong>'.$attribute['name'].'</strong><span class="show_att"></span></p>';

		$attr_slug = $attribute['slug'];

		echo '<ul class="variation-items-ul '.$attr_slug.'" data-id="'.$attr_slug.'" >';

		foreach ( $attribute['values'] as $value ) {
		    echo '<li class="variation-items-li'.(!empty($value['available']) ? '' : ' button-disabled').'" data-value="'.$value['slug'].'" data-slug="'.$attr_slug.'"><span class="variation-item-span">'.$value['name'].'</span></li>';
		}
		echo '</ul></div>';
	}

	echo '<div class="lb-clear-button">Clear</div>';