<?php
global $ays_fbl_db_version;
$ays_fbl_db_version = '3.2.5';
/**
 * Fired during plugin activation
 *
 * @link       https://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Ays_Facebook_Popup_Likebox
 * @subpackage Ays_Facebook_Popup_Likebox/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Ays_Facebook_Popup_Likebox
 * @subpackage Ays_Facebook_Popup_Likebox/includes
 * @author     AYS Pro LLC <info@ays-pro.com>
 */
class Ays_Facebook_Popup_Likebox_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	
	public static function activate() {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        global $wpdb;
        global $ays_fbl_db_version;
        $installed_ver = get_option( "ays_fbl_db_version" );

        $table = $wpdb->prefix . 'ays_fbl';
        $charset_collate = $wpdb->get_charset_collate();
        if($installed_ver != $ays_fbl_db_version) {
            
            $sql = "CREATE TABLE `" . $table . "` (
                      `id` INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
                      `title` VARCHAR(256) NOT NULL,
                      `description` TEXT NOT NULL,
                      `content` TEXT NOT NULL,
                      `header_options` TEXT NOT NULL,
                      `autoclose` INT NOT NULL,
                      `cookie` INT NOT NULL,
                      `url` TEXT NOT NULL,
                      `width` INT(16) NOT NULL,
                      `height` INT NOT NULL,
                      `bgcolor` VARCHAR(30) NOT NULL,
                      `textcolor` VARCHAR(30) NOT NULL, 
                      `bordersize` INT NOT NULL,  
                      `bordercolor` VARCHAR(30) NOT NULL, 
                      `border_radius` INT NOT NULL,
                      `custom_class` TEXT NOT NULL,
                      `custom_css` TEXT NOT NULL,
                      `onoffswitch` VARCHAR(20) NOT NULL,
                      `show_all` VARCHAR(20) NOT NULL,
                      `click_to_action` VARCHAR(20) NOT NULL,
                      `view_place` TEXT NOT NULL,
                      `delay` INT NOT NULL,
                      `scroll_top` INT NOT NULL,
                      `animate_in` VARCHAR(20) NOT NULL,
                      `animate_out` VARCHAR(20) NOT NULL,
                      `lang` VARCHAR(20) DEFAULT 'en_US',
                      `options` TEXT DEFAULT '',
                      PRIMARY KEY (`id`)
                    )$charset_collate;";

            $sql_schema = "SELECT * 
                    FROM INFORMATION_SCHEMA.TABLES
                    WHERE table_schema = '".DB_NAME."' 
                        AND table_name = '".$table."' ";
            $fb_const = $wpdb->get_results($sql_schema);
            
            if(empty($fb_const)){
                $wpdb->query( $sql );
            }else{
                dbDelta( $sql );
            }
            update_option('ays_fbl_db_version', $ays_fbl_db_version);
        }
	}

    public static function ays_fbl_db_check() {
        global $ays_fbl_db_version;
        if ( get_site_option( 'ays_fbl_db_version' ) != $ays_fbl_db_version ) {
            self::activate();
            self::alter_tables();
        }
    }

    private static function alter_tables(){
        global $wpdb;
        $table = $wpdb->prefix . 'ays_fbl';

        $query = "SELECT * FROM ".$table;
        $ays_pb_infos = $wpdb->query( $query );

        if($ays_pb_infos == 0){

            $query = "INSERT INTO ".$table." (title, description, content, header_options, autoclose, cookie, url, width, height, bgcolor, textcolor, bordersize, bordercolor, border_radius, custom_css, onoffswitch, show_all, click_to_action, view_place, delay, scroll_top, animate_in, animate_out, lang) VALUES ('Demo Title', 'Demo Description', 'timeline***events***messages', 'small_header***hide_cover_photo***show_friend_faces', '30', '0', 'https://www.facebook.com/wordpress', '500', '600', '#ffffff', '#000000', '1', '#ffffff', '4', '', 'On', 'yes', 'false', '', '0', '0', 'fadeIn', 'fadeOut', 'en_US')";
            $wpdb->query( $query );
        }
    }
}
