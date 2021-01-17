<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Ays_Facebook_Popup_Likebox
 * @subpackage Ays_Facebook_Popup_Likebox/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ays_Facebook_Popup_Likebox
 * @subpackage Ays_Facebook_Popup_Likebox/public
 * @author     AYS Pro LLC <info@ays-pro.com>
 */
class Ays_Facebook_Popup_Likebox_Public {

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

	/**
	 * Initialize the class and set its properties.
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
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

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
        wp_enqueue_style( 'fontawesom-afpl', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ays-facebook-popup-likebox-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'animate_fpl', plugin_dir_url( __FILE__ ) . 'css/animate.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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

		wp_enqueue_script( 'jquery-effects-core' );
        wp_enqueue_script( 'jquery-ui-sortable' );
        wp_enqueue_media();
		// wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ays-fb-pl.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ays-facebook-popup-likebox-public.js', array( 'jquery' ), $this->version, false );

	}

    public function ays_initialize_fbl_shortcode(){ 
		add_shortcode( 'ays_fb_popup_likebox', array($this, 'ays_generate_fblikebox') );
    }
	
    public function ays_fb_set_cookie($attr){
        $cookie_time = (isset($attr['cookie']) && $attr['cookie'] != 0) ? absint(intval($attr['cookie'])) : -1;
        $cookie_name = 'ays_fb_popup_cookie_'.$attr['id'];
        $cookie_value = $attr['title'];
        $cookie_expiration =  time() + ($cookie_time * 60);
		$aaaa = [$cookie_time, $cookie_name, $cookie_value, $cookie_expiration];		
        setcookie($cookie_name, $cookie_value, $cookie_expiration, '/');
    }

    public function ays_fb_remove_cookie($attr){
        $cookie_name = 'ays_fb_popup_cookie_'.$attr['id'];
        unset($_COOKIE[$cookie_name]);
        $cookie_expiration =  time() - 1;   
        setcookie($cookie_name, null, $cookie_expiration, '/');
    } 

    public function ays_fb_set_cookie_only_once($attr){
        $cookie_name = 'ays_show_fbl_only_once_'.$attr['id'];
        $cookie_value = $attr['title'];
        $cookie_expiration = time() + (10 * 365 * 24 * 60 * 60);
        setcookie($cookie_name, $cookie_value, $cookie_expiration, '/');
    }

    public function ays_fb_remove_cookie_only_once($attr){
        $cookie_name = 'ays_show_fbl_only_once_'.$attr['id'];
        if(isset($_COOKIE[$cookie_name])){
            unset($_COOKIE[$cookie_name]);
            $cookie_expiration =  time() - 1;   
            setcookie($cookie_name, null, $cookie_expiration, '/');
        }
    }
	
	public function ays_generate_fblikebox( $attr ){
        $current_lang = get_bloginfo("language");
        $id = ( isset($attr['id']) ) ? absint( intval( $attr['id'] ) ) : null;
		$fblikebox = $this->get_fb_likebox_by_id($id);
        $options = json_decode($fblikebox['options'], true);

        //Hide LikeBox on mobile
        if(isset($options['fb_mobile']) && $options['fb_mobile'] == "on"){
            $check_mobile_device = $this->ays_fb_detect_mobile_device();
            if ($check_mobile_device) {
                $fblikebox['onoffswitch'] = 'Off';
            }
        }

        // Checking guest or user 
        if (isset($options['popup_likebox_logged_users']) && isset($options['popup_likebox_guest'])){

            if ( is_user_logged_in() && $options['popup_likebox_logged_users'] != "On" || $options['popup_likebox_guest'] !='On' && $options['popup_likebox_logged_users'] != "On") {
                    $fblikebox['onoffswitch'] = 'Off';
            }
            elseif (!is_user_logged_in() && $options['popup_likebox_logged_users'] == "On"){
                if ($options['popup_likebox_guest'] !='On') {
                    $fblikebox['onoffswitch'] = 'Off';
                }
            }
        }
		if(isset($fblikebox['onoffswitch']) && $fblikebox['onoffswitch'] == 'On'){

            if(!isset($_COOKIE['ays_show_fbl_only_once_'.$id]) && isset($options['show_only_once']) && $options['show_only_once'] == 'on'){
                $this->ays_fb_set_cookie_only_once($fblikebox);
            }elseif(isset($options['show_only_once']) && $options['show_only_once'] == 'off'){
                $this->ays_fb_remove_cookie_only_once($fblikebox);
            }elseif(!isset($options['show_only_once'])){

            }else{
                return;
            }

			if(!isset($_COOKIE['ays_fb_popup_cookie_'.$id])){
				$this->ays_fb_set_cookie($fblikebox);
			}elseif((isset($fblikebox['cookie']) && $fblikebox['cookie'] == 0)){
                $this->ays_fb_remove_cookie($fblikebox);
            }else{
				return;
			}

            $ays_fb_language = (isset($fblikebox["lang"]) && $fblikebox["lang"] != '') ? $fblikebox["lang"] : 'en_US';
            if ($ays_fb_language == 'current_language') {
                $current_lang = str_replace("-", "_", $current_lang);
                $ays_fb_language = $current_lang;
            }

            $ays_fb_lang_array = array(
                'lang' => $ays_fb_language
            );            

            // CHecking exists box title option
            $options['popup_likebox_title'] = (!isset($options['popup_likebox_title'])) ? "On" : $options['popup_likebox_title'];

            $options['popup_likebox_description'] = (!isset($options['popup_likebox_description'])) ? "On" : $options['popup_likebox_description'];

            // Overlay 

            $onoffoverlay  = (isset($options["onoffoverlay"]) && $options["onoffoverlay"] != "") ? $options["onoffoverlay"] : "on";



            if(isset($options['popup_likebox_title']) && $options['popup_likebox_title'] == "On"){
                $show_title = $options['popup_likebox_title'];
            }else{
                $show_title = $options['popup_likebox_title'];
            }

            if(isset($options['popup_likebox_description']) && $options['popup_likebox_description'] == "On"){
                $show_description = $options['popup_likebox_description'];
            }else{
                $show_description = $options['popup_likebox_description'];
            }

            echo "<script>
                var ays_fb_language = ".json_encode($ays_fb_lang_array).";
            </script>";


            $ays_fb_url                     = $fblikebox["url"];
			$ays_fb_content                 = explode('***', $fblikebox["content"]);
			$ays_fb_content                 = implode(',', $ays_fb_content);
			$ays_fb_header_options          = explode('***', $fblikebox["header_options"]);
			$ays_fb_width                   = $fblikebox["width"];
			$ays_fb_height                  = $fblikebox["height"];
			$ays_fb_autoclose               = $fblikebox["autoclose"];
			$ays_fb_show_all                = $fblikebox["show_all"];
            $ays_fb_likebox_title           = $fblikebox["title"];
			$ays_fb_likebox_description     = __($fblikebox["description"], $this->plugin_name);
			$ays_fb_bgcolor					= $fblikebox["bgcolor"];
			$ays_fb_textcolor				= $fblikebox["textcolor"];
			$ays_fb_bordersize				= $fblikebox["bordersize"];
			$ays_fb_bordercolor				= $fblikebox["bordercolor"];
			$ays_fb_border_radius			= $fblikebox["border_radius"];
			$ays_fb_custom_css              = $fblikebox["custom_css"];
            $ays_fb_click_to_action         = $fblikebox["click_to_action"];
            $ays_fb_view_place              = explode( '***', $fblikebox["view_place"] );
            $ays_fb_delay                   = $fblikebox["delay"];
            $ays_fb_scroll_top              = $fblikebox["scroll_top"];
			$ays_fb_animate_in              = $fblikebox["animate_in"];
			$ays_fb_animate_out             = $fblikebox["animate_out"];
            $ays_fb_custom_class            = isset($fblikebox['custom_class']) && $fblikebox['custom_class'] != "" ? $fblikebox['custom_class'] : "";

            //Background Image
            $ays_fb_bg_image = (isset($options["bg_image"]) && $options['bg_image'] != "" ) ? $options["bg_image"] : "";
            
            //title font-size
            $ays_fb_title_fontsize = (isset($options["title_fontsize"]) && $options['title_fontsize'] != "" && $options['title_fontsize'] != 0) ? $options["title_fontsize"] : "32";
           
            //description font-size
            $ays_fb_description_fontsize = (isset($options["description_fontsize"]) && $options['description_fontsize'] != "" && $options['description_fontsize'] != "0") ? $options["description_fontsize"] : "13";

            //font-family
            $ays_fbl_font_family  = (isset($options['fbl_font_family']) && $options['fbl_font_family'] != '') ? $options['fbl_font_family'] : '';
          
            
            if($ays_fb_bg_image !== ''){
                $ays_fb_bg_image = 'background-image: url('.$ays_fb_bg_image.');
                                    background-repeat: no-repeat;
                                    background-size: cover;
                                    background-position: center center;';
            }

            if($ays_fb_likebox_title != ''  && $show_title == "On"){
                $ays_fb_likebox_title = "<h2 style='color: ".$ays_fb_textcolor." !important;font-family:".$ays_fbl_font_family.";font-size:".$ays_fb_title_fontsize."px'>".$ays_fb_likebox_title."</h2>";
            } else {$ays_fb_likebox_title = "";}
            
            if($ays_fb_likebox_description != ''  && $show_description == "On"){
                $ays_fb_likebox_description = "<h2 style='color: ".$ays_fb_textcolor." !important;font-family:".$ays_fbl_font_family.";font-size:".$ays_fb_description_fontsize."px'>".$ays_fb_likebox_description."</h2>";
            } else {$ays_fb_likebox_description = "";}

            if($ays_fb_delay == 0 && $ays_fb_scroll_top == 0){
                $open = "checked";
                $ays_fb_animate_in_open = $ays_fb_animate_in;
            }else{                
                $open = "";
                $ays_fb_animate_in_open = "";
            }

            // PopupBox container max-width for mobile
            if(isset($options['mobile_max_width']) && $options['mobile_max_width'] != ''){
                $mobile_max_width = $options['mobile_max_width'] . '%';
            }else{
                $mobile_max_width = '100%';
            }

             //close popup likebox by ESC
            $close_fbl_esc = (isset($options['close_fbl_esc']) && $options['close_fbl_esc'] == 'on') ? $options['close_fbl_esc'] : 'off';

             $close_fbl_esc_flag = false;

            if($close_fbl_esc == 'on'){
                $close_fbl_esc_flag = true;
            }

            $ays_fb_delay_second = (isset($ays_fb_delay) && ! empty($ays_fb_delay) && $ays_fb_delay > 0) ? ($ays_fb_delay / 1000) : 0;

            $fbpl_locale = get_locale();
            
			$fblikebox_view = '<style>'.$ays_fb_custom_css.'</style>
				<div class="ays-fpl-modals ">
                    <input type="hidden" value="'.$ays_fb_animate_in.'" id="ays_fpl_modal_animate_in_'.$id.'">
                    <input type="hidden" value="'.$ays_fb_animate_out.'" id="ays_fpl_modal_animate_out_'.$id.'">
					<input id="ays-fpl-modal-checkbox_'.$id.'" class="ays-fpl-modal-check" type="checkbox" '.$open.'/>
					<div class="ays-fpl-modal ays-fpl-modal_'.$id.' '.$ays_fb_animate_in_open.' '.$ays_fb_custom_class.' " style="'.$ays_fb_bg_image.';width: '.$ays_fb_width.'px; height: '.$ays_fb_height.'px; background-color: '.$ays_fb_bgcolor.'; color: '.$ays_fb_textcolor.' !important; border: '.$ays_fb_bordersize.'px solid '.$ays_fb_bordercolor.'; border-radius: '.$ays_fb_border_radius.'px;">
						<label for="ays-fpl-modal-checkbox_'.$id.'" class="ays-fpl-modal-close ays-fpl-modal-close_'.$id.'" style="color: '.$ays_fb_textcolor.';"><i class="fa fa-times fa-2x"></i></label>
                        '.$ays_fb_likebox_title.'
                        <p class="ays_fpl_description" style="font-size:'.$ays_fb_description_fontsize.'px">'.$ays_fb_likebox_description.'</p>
						<hr />
						<div class="ays_fpl_container">
							<div class="fb-page"
								 data-href="'.$ays_fb_url.'"
								 data-tabs="'.$ays_fb_content.'"
								 data-small-header="'.((in_array('small_header', $ays_fb_header_options)) ? "true" : "false" ).'"
								 data-height="'.( intval($ays_fb_height) - 200 ).'"
                                 data-width="'.(intval($ays_fb_width)).'"
								 data-hide-cover="'.((in_array('hide_cover_photo', $ays_fb_header_options)) ? "true" : "false" ).'"
								 data-show-facepile="'.((in_array('show_friend_faces', $ays_fb_header_options)) ? "true" : "false" ).'"
								 data-hide-cta="'.($ays_fb_click_to_action).'"
								 data-adapt-container-width="false">
								<blockquote cite="'.$ays_fb_url.'" class="fb-xfbml-parse-ignore">
									<a href="'.$ays_fb_url.'"></a>
								</blockquote>
							</div>
                        </div>';
                        if ($ays_fb_autoclose>0) {

                            if ($ays_fb_delay != 0 && ($ays_fb_autoclose < $ays_fb_delay_second || $ays_fb_autoclose >= $ays_fb_delay_second) ) {
                                $ays_fb_autoclose += floor($ays_fb_delay_second);
                            }
                            $fblikebox_view .= '<p class="ays_fpl_timer ays_fpl_timer_'.$id.'">'.(__("This will close in ", $this->plugin_name)).'<span data-seconds="'.$ays_fb_autoclose.'"> '.$ays_fb_autoclose.' </span>'.(__(" seconds", $this->plugin_name)).' </p>';
                        }
					$fblikebox_view .= '</div>
					<div id="ays-fpl-screen-shade_'.$id.'"></div>
                    <input type="hidden" class="ays_fpl_delay_'.$id.'" value="'.$ays_fb_delay.'"/>
                    <input type="hidden" class="ays_fpl_scroll_'.$id.'" value="'.$ays_fb_scroll_top.'"/>
                    <input type="hidden" class="ays_fpl_locale" value="'.$fbpl_locale.'"/>
				</div>';
            
               $fblikebox_view .= "
                <style>
                    .ays-fpl-modal-check:checked ~ #ays-fpl-screen-shade_".$id." {
                        opacity: 0.5;
                        pointer-events: auto;
                    }

                    #ays-fpl-screen-shade_".$id." {
                        opacity: 0;
                        background: #000;
                        position: absolute;
                        left: 0;
                        right: 0;
                        top: 0;
                        bottom: 0;
                        pointer-events: none;
                        transition: opacity 0.8s;
                    }

                    .ays-fpl-modal_".$id." .ays_fpl_description, 
                    .ays-fpl-modal_".$id." .ays_fpl_timer{
                        color: ".$ays_fb_textcolor." !important;
                        font-family: ".$ays_fbl_font_family." !important;
                    }

                    @media screen and (max-width: 768px){
                        .ays-fpl-modal_".$id."{
                            max-width: $mobile_max_width;
                        }
                    }
                </style>
                <script>
                (function( $ ) {
                    'use strict';
                    $(document).ready(function(){
                        let time_fpl_".$id." = $(document).find('p.ays_fpl_timer_".$id." span').data('seconds'),
                            ays_fpl_effectOut_".$id." = $(document).find('#ays_fpl_modal_animate_out_".$id."').val(),
                            ays_fpl_scrollTop_".$id." = Number($(document).find('.ays_fpl_scroll_".$id."').val()),
                            ays_fpl_delayOpen_".$id." = Number($(document).find('.ays_fpl_delay_".$id."').val()),
                            ays_fpl_effectIn_".$id." = $(document).find('#ays_fpl_modal_animate_in_".$id."').val();
                        if(time_fpl_".$id." !== undefined){
                            if(ays_fpl_scrollTop_".$id." == 0){
                                let timer_fpl_".$id." = setInterval(function(){
                                    let newTime_fpl_".$id." = time_fpl_".$id."--;
                                    
                                    $(document).find('p.ays_fpl_timer_".$id." span').text(newTime_fpl_".$id.");
                                    if(newTime_fpl_".$id." <= 0){
                                        $(document).find('.ays-fpl-modal-close_".$id."').trigger('click');
                                        $(document).find('.ays-fpl-modal_".$id."').attr('class', 'ays-fpl-modal ays-fpl-modal_".$id." '+ays_fpl_effectOut_".$id.");
                                        setTimeout(function(){ $(document).find('.ays-fpl-modal_".$id."').css('display', 'none');}, 500);
                                        clearInterval(timer_fpl_".$id.");
                                    }
                                    var ays_fpl_flag = true;
                                    $(document).on('keydown', function(event) { 
                                                if('".$close_fbl_esc_flag."' && ays_fpl_flag){
                                                    if (event.keyCode == 27) { 

                                                        $(document).find('.ays-fpl-modal-close_".$id."').trigger('click');
                                                    } 
                                                }
                                                ays_fpl_flag = false;
                                            });
                                    
                                },1000);
                            }
                        }
                        $(document).find('.ays-fpl-modal-close_".$id."').on('click', function(){
                            $(document).find('.ays-fpl-modal_".$id."').attr('class', 'ays-fpl-modal ays-fpl-modal_".$id." '+ays_fpl_effectOut_".$id.");
                            setTimeout(function(){ $(document).find('.ays-fpl-modal_".$id."').css('display', 'none'); }, 400);  
                            setTimeout(function(){ $(document).find('#ays-fpl-screen-shade_".$id."').css({'opacity': '0', 'display': 'none'}); }, 500);
                            setTimeout(function(){ $(document).find('.ays-fpl-modal_".$id."').remove(); }, 500);
                        });

                        if( ays_fpl_scrollTop_".$id." !== 0 ){
                            let flag_1 = 0,
                                flag_2 = 0;
                            $(window).scroll(function() {
                                if($(this).scrollTop() >= ays_fpl_scrollTop_".$id.") {
                                    if( ays_fpl_delayOpen_".$id." !== 0 ){   
                                        if(flag_1 === 0){
                                            flag_1 = 1;
                                            $(document).find('.ays-fpl-modal_".$id."').css('animation-delay', ays_fpl_delayOpen_".$id."/1000);
                                            setTimeout(function(){
                                                $(document).find('.ays-fpl-modal_".$id."').addClass(ays_fpl_effectIn_".$id.");
                                                $(document).find('.ays-fpl-modal_".$id."').css('display', 'block');
                                                $(document).find('#ays-fpl-screen-shade_".$id."').css({'opacity': '0.5'});
                                                $(document).find('#ays-fpl-modal-checkbox_".$id."').prop('checked', true);
                                            }, ays_fpl_delayOpen_".$id.");
                                        }            
                                    }else{
                                        $(document).find('.ays-fpl-modal_".$id."').addClass(ays_fpl_effectIn_".$id.");
                                        $(document).find('.ays-fpl-modal_".$id."').css('display', 'block');
                                        $(document).find('#ays-fpl-screen-shade_".$id."').css({'opacity': '0.5'});
                                        $(document).find('#ays-fpl-modal-checkbox_".$id."').prop('checked', true);
                                    }
                                }
                                if(flag_2 === 0){
                                    flag_2 = 1;
                                    if(time_fpl_".$id." !== undefined){
                                        let timer_fpl_".$id." = setInterval(function(){
                                            let newTime_fpl_".$id." = time_fpl_".$id."--;
                                            $(document).find('p.ays_fpl_timer_".$id." span').text(newTime_fpl_".$id.");
                                            if(newTime_fpl_".$id." <= 0){
                                                $(document).find('.ays-fpl-modal-close_".$id."').trigger('click');
                                                $(document).find('.ays-fpl-modal_".$id."').attr('class', 'ays-fpl-modal ays-fpl-modal_".$id." '+ays_fpl_effectOut_".$id.");
                                                setTimeout(function(){ $(document).find('.ays-fpl-modal_".$id."').css('display', 'none');}, 500);
                                                clearInterval(timer_fpl_".$id.");
                                            }
                                            var ays_fpl_flag = true;
                                                $(document).on('keydown', function(event) { 
                                                    if('".$close_fbl_esc_flag."' && ays_fpl_flag){
                                                        if (event.keyCode == 27) {   

                                                            $(document).find('.ays-fpl-modal-close_".$id."').trigger('click');
                                                            ays_fpl_flag = false;
                                                        } 
                                                    }
                                                });
                                            
                                        },1000);
                                    }
                                }
                            });
                        }else{
                            if( ays_fpl_delayOpen_".$id." !== 0 ){
                                $(document).find('.ays-fpl-modal_".$id."').css('animation-delay', ays_fpl_delayOpen_".$id."/1000);
                                setTimeout(function(){
                                    $(document).find('.ays-fpl-modal_".$id."').addClass(ays_fpl_effectIn_".$id.");
                                    $(document).find('.ays-fpl-modal_".$id."').css('display', 'block');
                                    $(document).find('#ays-fpl-screen-shade_".$id."').css({'opacity': '0.5'});
                                    $(document).find('#ays-fpl-modal-checkbox_".$id."').prop('checked', true);
                                }, ays_fpl_delayOpen_".$id.");
                            }else{
                                $(document).find('.ays-fpl-modal_".$id."').addClass(ays_fpl_effectIn_".$id.");
                                $(document).find('.ays-fpl-modal_".$id."').css('display', 'block');
                                $(document).find('#ays-fpl-screen-shade_".$id."').css({'opacity': '0.5'});
                                $(document).find('#ays-fpl-modal-checkbox_".$id."').prop('checked', true);
                            }
                        }
                    });
                    if ('".$onoffoverlay."' != 'on'){
                                $(document).find('#ays-fpl-screen-shade_".$id."').css({'opacity': '0', 'display': 'none !important', 'pointer-events': 'none', 'background': 'none'});
                                $(document).find('.ays-fpl-modal_".$id."').css('pointer-events', 'auto');
                                $(document).find('.ays-fpl-modals_".$id."').css('pointer-events','none');
                            };
                    })( jQuery );
                </script>";
            return $fblikebox_view;			
		}
    }

    public function ays_fbl_shortcodes_show_all(){
        global $wpdb;    
        $post_id = get_the_ID();
        $sql2 = "SELECT * FROM {$wpdb->prefix}ays_fbl WHERE view_place <> '' ";
        $result2 = $wpdb->get_results($sql2, "ARRAY_A");
        if(!empty($result2)){
            foreach($result2 as $key => $i){
                $ays_fb_view_place  = explode( '***', $i["view_place"] );
                if(in_array($post_id, $ays_fb_view_place)){
                    $shortcode2 = "[ays_fb_popup_likebox id={$i['id']} w={$i['width']} h={$i['height']} ]";
                    echo do_shortcode($shortcode2);
                }
            }
        }
        $sql = "SELECT * FROM {$wpdb->prefix}ays_fbl WHERE show_all = 'yes'";
        $result = $wpdb->get_results($sql, "ARRAY_A");
        if(!empty($result)){
            foreach($result as $key => $i){
                $shortcode = "[ays_fb_popup_likebox id={$i['id']} w={$i['width']} h={$i['height']} ]";
                echo do_shortcode($shortcode);
            }
        }
        
    }
	
	public function get_fb_likebox_by_id( $id ){
        global $wpdb;

        $sql = "SELECT * FROM {$wpdb->prefix}ays_fbl WHERE id=" . absint( intval( $id ) );

        $result = $wpdb->get_row($sql, "ARRAY_A");

        return $result;
    }

    public function ays_fb_detect_mobile_device(){
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $flag      = false;
        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
            $flag = true;
        }
        return $flag;
    }

    private function array_split($array, $pieces) {
        if ($pieces < 2)
            return array($array);
        $newCount = ceil(count($array)/$pieces);
        $a = array_slice($array, 0, $newCount);
        $b = $this->array_split(array_slice($array, $newCount), $pieces-1);
        return array_merge(array($a),$b);
    }
}
