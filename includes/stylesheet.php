<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
?>

<style type="text/css">

/* Button background color */
.variation-items-ul .variation-items-li {
    background-color: <?php echo $background_color ?> !important;
}

/* Hover button color */
.lb-available-attributes .variation-items-li:hover {
    background-color: <?php echo $hover_color ?> !important;
}

/* Button selected */
.lb-available-attributes .button-selected {
    background-color: <?php echo $selected_button_color ?> !important;  
}

/* Text color inside buttons */
.lb-available-attributes .variation-item-span {
    color: <?php echo $font_color ?> !important;
}

/* Hover text color inside buttons */
.lb-available-attributes .variation-items-li:hover .variation-item-span {
    color: <?php echo $font_hover_color ?> !important;
}

/* Text color when button is selected */
.lb-available-attributes .button-selected span {
    color: <?php echo $selected_font_color ?> !important;  
}

</style>