<?php
if( ! defined( 'ABSPATH' ) ) { exit; }
if ( count( get_included_files() ) == 1 ){ exit(); }

/**
 * Plugin Admin Sidebar
 */
?>
<div class="postbox">
    <h3><span><?php echo $this->menu_name;?></span></h3>
<div class="inside"><div class="para">

    <?php echo $this->links();?>

</div></div> <!-- end inside-pad & inside -->
</div> <!-- end postbox -->
