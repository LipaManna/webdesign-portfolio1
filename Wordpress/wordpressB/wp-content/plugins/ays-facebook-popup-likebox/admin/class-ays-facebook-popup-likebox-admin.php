<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Ays_Facebook_Popup_Likebox
 * @subpackage Ays_Facebook_Popup_Likebox/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ays_Facebook_Popup_Likebox
 * @subpackage Ays_Facebook_Popup_Likebox/admin
 * @author     AYS Pro LLC <info@ays-pro.com>
 */
class Ays_Facebook_Popup_Likebox_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	private $fblikebox_obj;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        add_filter( 'set-screen-option', [ __CLASS__, 'set_screen' ], 10, 3 );
        $per_page_array = array(
            'fblikeboxes_per_page',
        );
        foreach($per_page_array as $option_name){
            add_filter('set_screen_option_'.$option_name, array(__CLASS__, 'set_screen'), 10, 3);
        }

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles($hook_suffix) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ays_Facebook_Popup_Likebox_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ays_Facebook_Popup_Likebox_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
        wp_enqueue_style( $this->plugin_name.'-icon', plugin_dir_url( __FILE__ ) . 'css/ays-fpl-icon.css', array(), $this->version, 'all' );
        if(false === strpos($hook_suffix, $this->plugin_name))
            return;
		wp_enqueue_style( 'wp-color-picker' );	
        wp_enqueue_style( 'ays_fpl_font_awesome', 'https://use.fontawesome.com/releases/v5.2.0/css/all.css', array(), $this->version, 'all' );
        wp_enqueue_style( 'ays_fpl_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css', array(), $this->version, 'all' );
        wp_enqueue_style( 'ays-fpl-select2', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'fpl_animate', plugin_dir_url( __FILE__ ) . 'css/animate.css', array(), $this->version, 'all' );
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ays-facebook-popup-likebox-admin.css', array(), $this->version, 'all' );
        wp_enqueue_style('ays_code_mirror', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.48.4/codemirror.css', array(), $this->version, 'all');

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts($hook_suffix) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ays_Facebook_Popup_Likebox_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ays_Facebook_Popup_Likebox_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if (false !== strpos($hook_suffix, "plugins.php")){
            wp_enqueue_script($this->plugin_name . '-admin', plugin_dir_url(__FILE__) . 'js/admin.js', array('jquery'), $this->version, true);
            wp_localize_script($this->plugin_name . '-admin', 'fb_likebox_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
        }
        if(false === strpos($hook_suffix, $this->plugin_name))
            return;
		wp_enqueue_script( 'jquery-effects-core' );
        wp_enqueue_script( 'jquery-ui-sortable' );
        wp_enqueue_media();        
        wp_enqueue_script( "ays_fpl_popper", 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array( 'jquery' ), $this->version, false );
        wp_enqueue_script( "ays_fpl_bootstrap", 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js', array( 'jquery' ), $this->version, false );
        wp_enqueue_script( 'select2js', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js', array('jquery'), $this->version, true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ays-facebook-popup-likebox-admin.js', array( 'jquery', 'wp-color-picker' ), $this->version, true );
        wp_enqueue_script( $this->plugin_name . 'custom-dropdown-adapter', plugin_dir_url( __FILE__ ) . 'js/ays-select2-dropdown-adapter.js', array('jquery'), $this->version, true );

	}

	  function codemirror_enqueue_scripts($hook) {
        if (false === strpos($hook, $this->plugin_name)){
            return;
        }
        if(function_exists('wp_enqueue_code_editor')){
            $cm_settings['codeEditor'] = wp_enqueue_code_editor(array(
                'type' => 'text/css',
                'codemirror' => array(
                    'inputStyle' => 'contenteditable',
                    'theme' => 'cobalt',
                   
                )
            ));

            wp_enqueue_script('wp-theme-plugin-editor');
            wp_localize_script('wp-theme-plugin-editor', 'cm_settings', $cm_settings);
        
            wp_enqueue_style('wp-codemirror');
        }
    }

    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since    1.0.0
     */
	
	
    public function add_plugin_admin_menu() {
		
        add_options_page(__('Facebook Popup Likebox', $this->plugin_name), __('Facebook Popup Likebox', $this->plugin_name), 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page'));		
        $hook_fblikebox = add_menu_page( __('Facebook Popup Likebox', $this->plugin_name), __('Facebook Popup Likebox', $this->plugin_name), 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page'), AYS_FPL_ADMIN_URL . 'images/fbl_icon.png', 6);
		
		add_action( "load-$hook_fblikebox", [ $this, 'screen_option_fblikebox' ] );
    }

    /**
     * Add settings action link to the plugins page.
     *
     * @since    1.0.0
     */

    public function add_action_links( $links ) {
        /*
        *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
        */
        $settings_link = array(
            '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
        );
        return array_merge(  $settings_link, $links );

    }

    public function display_plugin_setup_page() {
		$action = (isset($_GET['action'])) ? sanitize_text_field( $_GET['action'] ) : '';
		
        switch ( $action ) {
            case 'add':
                include_once( 'partials/actions/ays-facebook-popup-likebox-admin-actions.php' );
                break;
            case 'edit':
                include_once( 'partials/actions/ays-facebook-popup-likebox-admin-actions.php' );
                break;
            default:
                include_once( 'partials/ays-facebook-popup-likebox-admin-display.php' );
        }
    }
	
	public static function set_screen( $status, $option, $value ) {
        return $value;
    }
	
	public function screen_option_fblikebox() {
		$option = 'per_page';
		$args   = [
			'label'   => __('Facebook LikeBox', $this->plugin_name),
			'default' => 20,
			'option'  => 'fblikeboxes_per_page'
		];

		add_screen_option( $option, $args );
		$this->fblikebox_obj = new FB_Popup_Likebox_List_Table($this->plugin_name);
	}

	public function deactivate_plugin_option(){
        error_reporting(0);
        $request_value = $_REQUEST['upgrade_plugin'];
        $upgrade_option = get_option('ays_fb_upgrade_plugin','');
        if($upgrade_option === ''){
            add_option('ays_fb_upgrade_plugin',$request_value);
        }else{
            update_option('ays_fb_upgrade_plugin',$request_value);
        }
        echo json_encode(array('option'=>get_option('ays_fb_upgrade_plugin','')));
        wp_die();
    }
	
}
