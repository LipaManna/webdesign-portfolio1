<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://ays-pro.com/
 * @since             1.0.0
 * @package           Ays_Facebook_Popup_Likebox
 *
 * @wordpress-plugin
 * Plugin Name:       Facebook Popup Likebox
 * Plugin URI:        https://ays-pro.com/index.php/wordpress/facebook-popup-likebox
 * Description:       With the help of this  amazing plugin you can promote your Facebook page and add number of Like
 * Version:           3.5.0
 * Author:            Popup LikeBox Team
 * Author URI:        https://ays-pro.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ays-facebook-popup-likebox
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'AYS_FPL_NAME_VERSION', '3.5.0' );
define( 'AYS_FPL_NAME', 'ays-facebook-popup-likebox' );

if( ! defined( 'AYS_FPL_ADMIN_URL' ) ) {
    define( 'AYS_FPL_ADMIN_URL', plugin_dir_url(__FILE__ ) . 'admin/' );
}


if( ! defined( 'AYS_FPL_PUBLIC_URL' ) ) {
    define( 'AYS_FPL_PUBLIC_URL', plugin_dir_url(__FILE__ ) . 'public/' );
}
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ays-facebook-popup-likebox-activator.php
 */
function activate_ays_facebook_popup_likebox() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ays-facebook-popup-likebox-activator.php';
	Ays_Facebook_Popup_Likebox_Activator::ays_fbl_db_check();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ays-facebook-popup-likebox-deactivator.php
 */
function deactivate_ays_facebook_popup_likebox() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ays-facebook-popup-likebox-deactivator.php';
	Ays_Facebook_Popup_Likebox_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ays_facebook_popup_likebox' );
register_deactivation_hook( __FILE__, 'deactivate_ays_facebook_popup_likebox' );

add_action( 'plugins_loaded', 'activate_ays_facebook_popup_likebox' );
/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ays-facebook-popup-likebox.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ays_facebook_popup_likebox() {

    add_action( 'admin_notices', 'general_fpl_admin_notice' );
	$plugin = new Ays_Facebook_Popup_Likebox();
	$plugin->run();

}

function general_fpl_admin_notice(){
    if ( isset($_GET['page']) && strpos($_GET['page'], AYS_FPL_NAME) !== false ) {
        ?>
             <div class="ays-notice-banner">
                <div class="navigation-bar">
                    <div id="navigation-container">
                        <a class="logo-container" href="https://ays-pro.com/" target="_blank">
                            <img class="logo" src="<?php echo AYS_FPL_ADMIN_URL . '/images/ays_pro.png'; ?>" alt="AYS Pro logo" title="AYS Pro logo"/>
                        </a>
                        <ul id="menu">
                            <li><a class="ays-btn" href="https://freedemo.ays-pro.com/facebook-popup-likebox-demo-free/" target="_blank">Demo</a></li>
                            <li><a class="ays-btn" href="https://ays-pro.com/index.php/wordpress/facebook-popup-likebox" target="_blank">PRO</a></li>
                            <li><a class="ays-btn" href="https://wordpress.org/support/plugin/ays-facebook-popup-likebox" target="_blank">Support Chat</a></li>
                            <li><a class="ays-btn" href="https://ays-pro.com/index.php/contact/" target="_blank">Contact us</a></li>
                        </ul>
                    </div>
                </div>
             </div>
        <?php
    }
}

run_ays_facebook_popup_likebox();
