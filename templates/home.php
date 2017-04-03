<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( count( get_included_files() ) == 1 ){ exit(); }?>

<b><?php _e( 'Instructions/about settings...', 'my-starter-plugin' );?></b>

<br />

<form enctype="multipart/form-data" method="post" action="">
<?php wp_nonce_field( $this->option_name . 'action', $this->option_name . 'nonce' );?>
<input type="hidden" name="type" value="update" />

    <h3><?php _e( 'Section Title', 'my-starter-plugin' );?></h3>
    <?php _e( 'Section About', 'my-starter-plugin' );?>

    <table class="form-table">
    <tbody>
    <tr>
        <th scope="row"><?php _e( 'Checkbox Setting', 'my-starter-plugin' );?></th>
        <td><input type="checkbox" name="checkbox_name" value="1" id="checkbox_name" <?php checked( parent::option( 'checkbox_name' ), 1 );?>/> <label class="description" for="checkbox_name"><?php _e( 'About this setting.', 'my-starter-plugin' );?></label></td>
    </tr><tr>
        <th scope="row"><?php _e( 'Radio Setting', 'my-starter-plugin' );?></th>
        <td><input type="radio" name="radio_name" value="unique_value_1" id="radio_name" <?php checked( parent::option( 'radio_name' ), 'unique_value_1' );?>/> <label class="description" for="radio_name"><?php _e( 'About this setting.', 'my-starter-plugin' );?></label></td>
    </tr><tr>
        <th scope="row"><?php _e( 'Radio Setting', 'my-starter-plugin' );?></th>
        <td><input type="radio" name="radio_name" value="unique_value_2" id="radio_name" <?php checked( parent::option( 'radio_name' ), 'unique_value_2' );?>/> <label class="description" for="radio_name"><?php _e( 'About this setting.', 'my-starter-plugin' );?></label></td>
    </tr><tr>
        <th scope="row"><?php _e( 'Text Input Setting', 'my-starter-plugin' );?></th>
        <td><input type="text" name="text_name" value="<?php echo parent::option( 'text_name' );?>" /><p class="description"><?php _e( 'About this setting.', 'my-starter-plugin' );?></p></td>
    </tr>
    </tbody>
    </table>

    <div class="textcenter"><?php submit_button( __( 'update settings', 'my-starter-plugin' ) );?></div>

</form>

<br /><hr /><br />

<form enctype="multipart/form-data" method="post" action="">
<?php wp_nonce_field( $this->option_name . 'action', $this->option_name . 'nonce' );?>

    <table class="form-table">
    <tr>
        <td class="textright"><label><?php _e( 'WARNING: Delete all saved settings for ' . $this->plugin_title, 'my-starter-plugin' );?></label> <input type="radio" name="type" value="delete" /></td>
    </tr>
    </table>

    <p class="textright"><input type="submit" name="submit" value=" submit " onclick="return confirm( 'Are You Sure?' );" /></p>

</form>
