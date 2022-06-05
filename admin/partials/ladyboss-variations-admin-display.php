<?php

/**
 *
 * @link       https://ladyboss.com/store
 * @since      1.0.0
 *
 * @package    Ladyboss_Variations
 * @subpackage Ladyboss_Variations/admin/partials
 */
?>

<div class="jumbotron">
<h1>LadyBoss Variations for WooCommerce Settings</h1>
    <form method="post" action="options.php">
    <?php
    settings_fields( 'lb-variation-settings' );

    do_settings_sections( 'lb-variation-settings' );
    ?>  
    <table class="form-table">
        <tbody>
            <tr>
                <th><label class="form-check-label" for="checkbox-setting"><b>Enable custom settings</b></label></th>                
                <td><input type="checkbox" class="form-check-input" id="checkbox-setting" name="checkbox-setting" <?php echo get_option( 'checkbox-setting' ) == 'on' ? 'checked' : ''; ?> ></td>
            </tr>
            <tr>
                <th><b>Button styling</b></th>
            </tr>
            <tr>
                <th><label class="form-check-label" for="bcg-btn"><b>Change button background color</b></label></th>
                <td><input type="text" name="bgc-btn" value="<?php echo get_option( 'bgc-btn' ); ?>" class="lb-color-picker"></td>
            </tr>  
            <tr>  
                <th><label class="form-check-label" for="hov-btn"><b>Change button hover color</b></label></th>
                <td><input type="text" name="hov-btn" value="<?php echo get_option( 'hov-btn' ); ?>" class="lb-color-picker"></td>
            </tr>
            <tr>  
                <th><label class="form-check-label" for="selected-btn"><b>Change button selected color</b></label></th>
                <td><input type="text" name="selected-btn" value="<?php echo get_option( 'selected-btn' ); ?>" class="lb-color-picker"></td>
            </tr>
            <tr>
                <th><b>Button text styling</b></th>
            </tr>
            <tr>
                <th><label class="form-check-label" for="text-color-btn"><b>Change text color</b></label></th>
                <td><input type="text" name="text-color-btn" value="<?php echo get_option( 'text-color-btn' ); ?>" class="lb-color-picker"></td>
            </tr>
            <tr>  
                <th><label class="form-check-label" for="hov-text"><b>Change text hover color</b></label></th>
                <td><input type="text" name="hov-text" value="<?php echo get_option( 'hov-text' ); ?>" class="lb-color-picker"></td>
            </tr>
            <tr>  
                <th><label class="form-check-label" for="selected-text"><b>Change text selected color</b></label></th>
                <td><input type="text" name="selected-text" value="<?php echo get_option( 'selected-text' ); ?>" class="lb-color-picker"></td>
            </tr>
        </tbody>
    </table>
        <button type="submit" class="button-primary btn btn-primary">Save Changes</button>
    </form>
</div>