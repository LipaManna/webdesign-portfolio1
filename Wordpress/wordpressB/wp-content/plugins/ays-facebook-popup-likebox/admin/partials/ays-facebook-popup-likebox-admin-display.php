<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Ays_Facebook_Popup_Likebox
 * @subpackage Ays_Facebook_Popup_Likebox/admin/partials
 */
$action = ( isset($_GET['action']) ) ? $_GET['action'] : '';
$id     = ( isset($_GET['fblikebox']) ) ? $_GET['fblikebox'] : null;

if($action == 'unpublish' || $action == 'publish'){
$this->fblikebox_obj->ays_fb_publish_unpublish($id,$action);
}
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <h1 class="wp-heading-inline">
        <?php
        echo esc_html(get_admin_page_title());
        echo sprintf( '<a href="?page=%s&action=%s" class="page-title-action">'. __( "Add New" ) .'</a>', esc_attr( $_REQUEST['page'] ), 'add');
        ?>
    </h1>

    <div id="poststuff">
        <div id="post-body" class="metabox-holder">
            <div id="post-body-content">
                <div class="meta-box-sortables ui-sortable">
                    <form method="post">
                        <?php
                        $this->fblikebox_obj->prepare_items();
                        $this->fblikebox_obj->display();
                        ?>
                    </form>
                </div>
            </div>
        </div>
        <br class="clear">
    </div>
</div>
