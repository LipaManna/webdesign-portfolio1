<?php
if(isset($_GET['ays_fb_tab'])){
    $ays_fb_tab = $_GET['ays_fb_tab'];
}else{
    $ays_fb_tab = 'tab1';
}

$action = (isset($_GET['action'])) ? sanitize_text_field( $_GET['action'] ) : '';
$heading = '';
$id = ( isset( $_GET['fblikebox'] ) ) ? absint( intval( $_GET['fblikebox'] ) ) : null;
$current_lang = get_bloginfo("language");

$options = array(
    'popup_likebox_title'        => "On",
    'popup_likebox_description'  => "On",
    'popup_likebox_guest'        => 'Off',
    'popup_likebox_logged_users' => 'On',
    'mobile_max_width'           => '' , 
    'fb_mobile'                  => 'off',
    'bg_image'                   => '',
    'close_fbl_esc'              => 'off',
    'onoffoverlay'               => 'on',
);

$fblikebox = [
    "id"            	=> "",
	"title"         	=> "Default title",
	"description"   	=> "Default description",
	"content"        	=> "timeline***events***messages",
	"header_options"	=> "small_header***hide_cover_photo***show_friend_faces",
	"autoclose"  		=> "30",
	"cookie"   			=> "0",
	"url"   			=> "https://www.facebook.com/wordpress",
	"width"         	=> "500",
	"height"        	=> "600",
	"bgcolor"        	=> "#ffffff",
	"textcolor"        	=> "#000000",
	"bordersize"        => "1",
	"bordercolor"       => "#ffffff",
	"border_radius"     => "4",
	"custom_css"        => "",
	"onoffswitch"       => "On",
	"show_all"          => "yes",
	"click_to_action"   => "false",
	"view_place"        => "",
	"delay"             => "0",
	"scroll_top"        => "0",
	"animate_in"        => "fadeIn",
	"animate_out"       => "fadeOut",
	"lang"              => "current_language",
    "custom_class"      => "",
    "options"           => json_encode($options)
];

switch( $action ) {
    case 'add':
        if ($id == null) {
            $heading = __( 'Add new Facebook LikeBox', $this->plugin_name);            
            break;
        }
    case 'edit':
        $heading = __( 'Edit Facebook LikeBox', $this->plugin_name);
        $fblikebox = $this->fblikebox_obj->get_fb_likebox_by_id($id);
        break;
}

if (isset($_POST['ays_submit']) || isset($_POST['ays_submit_top'])) {
    $_POST['id'] = $id;
    $this->fblikebox_obj->add_or_edit_fb_likebox($_POST);

}
if (isset($_POST['ays_apply_top']) || isset($_POST['ays_apply'])) {
    $_POST["id"] = $id;
    $_POST['ays_change_type'] = 'apply';
    $this->fblikebox_obj->add_or_edit_fb_likebox($_POST);
    
}

$options = json_decode($fblikebox['options'], true);

$options['popup_likebox_title'] = (!isset($options['popup_likebox_title'])) ? "On" : $options['popup_likebox_title'];
$options['popup_likebox_description'] = (!isset($options['popup_likebox_description'])) ? "On" : $options['popup_likebox_description'];
$options['popup_likebox_guest'] = (!isset($options['popup_likebox_guest'])) ? "On" : $options['popup_likebox_guest'];
$options['popup_likebox_logged_users'] = (!isset($options['popup_likebox_logged_users'])) ? "On" : $options['popup_likebox_logged_users'];

// PopupBox max-width for mobile option
$mobile_max_width = (isset($options['mobile_max_width']) && $options['mobile_max_width'] != "") ? $options['mobile_max_width'] : '';

//Hide popupbox on mobile
$fb_mobile = (isset($options['fb_mobile']) && $options['fb_mobile'] == 'on') ? $options['fb_mobile'] : 'off';

//Show LikeBox only once
$show_only_once = (isset($options['show_only_once']) && $options['show_only_once'] == 'on') ? 'on' : 'off';

// Overlay
$onoffoverlay  = (isset($options["onoffoverlay"]) && $options["onoffoverlay"] != "") ? $options["onoffoverlay"] : "on";

//Close popup likebox by ESC 
$close_fbl_esc  = (isset($options['close_fbl_esc']) && $options['close_fbl_esc'] == 'on') ? 'on' : 'off';


//Background image
$bg_image  = (isset($options['bg_image']) && !empty($options['bg_image']) ) ? $options['bg_image'] : '';
if ($bg_image != '') {
    $style_bg      = "display: block;";
    $image_text_bg = __('Edit Image', $this->plugin_name);
}else{
    $style_bg   = "display: none;";
    $image_text_bg = __('Add Image', $this->plugin_name);
}

$show_popup_likebox_title =  $options['popup_likebox_title'];
$show_popup_likebox_description =  $options['popup_likebox_description'];
$show_popup_likebox_guest =  $options['popup_likebox_guest'];
$show_popup_likebox_logged_users =  $options['popup_likebox_logged_users'];

//font-family option
$font_families = array(
    'arial'               => __('Arial', $this->plugin_name),
    'arial black'         => __('Arial Black', $this->plugin_name),
    'book antique'        => __('Book Antique', $this->plugin_name),
    'courier new'         => __('Courier New', $this->plugin_name),
    'cursive'             => __('Cursive', $this->plugin_name),
    'fantasy'             => __('Fantasy', $this->plugin_name),
    'georgia'             => __('Georgia', $this->plugin_name),
    'helvetica'           => __('Helvetia', $this->plugin_name),
    'impact'              => __('Impact', $this->plugin_name),
    'lusida console'      => __('Lusida Console', $this->plugin_name),
    'palatino linotype'   => __('Palatino Linotype', $this->plugin_name),
    'tahoma'              => __('Tahoma', $this->plugin_name),
    'times new roman'     => __('Times New Roman', $this->plugin_name),
);
$font_family_option = (isset($options['fbl_font_family']) && $options['fbl_font_family'] != '') ? $options['fbl_font_family'] : '';

// Custom class for quiz container
$custom_class = (isset($fblikebox['custom_class']) && $fblikebox['custom_class'] != "") ? $fblikebox['custom_class'] : '';

//Title Font-size
$title_fontsize = (isset($options['title_fontsize']) && $options['title_fontsize'] != '0') ? $options['title_fontsize'] : '32';

//Title description
$description_fontsize = (isset($options['description_fontsize']) && $options['description_fontsize'] != '0') ? $options['description_fontsize'] : '13';



$ays_lang_arr = array(
    "current_language" => "Current Language",
    "af_ZA" => "Afrikaans",
    "ar_AR" => "Arabic",
    "az_AZ" => "Azerbaijani",
    "be_BY" => "Belarusian",
    "bg_BG" => "Bulgarian",
    "bn_IN" => "Bengali",
    "bs_BA" => "Bosnian",
    "ca_ES" => "Catalan",
    "cs_CZ" => "Czech",
    "cx_PH" => "Cebuano",
    "cy_GB" => "Welsh",
    "da_DK" => "Danish",
    "de_DE" => "German",
    "el_GR" => "Greek",
    "en_GB" => "English (UK)",
    "en_PI" => "English (Pirate)",
    "en_UD" => "English (Upside Down)",
    "en_US" => "English (US)",
    "eo_EO" => "Esperanto",
    "es_ES" => "Spanish",
    "es_LA" => "Spanish",
    "et_EE" => "Estonian",
    "eu_ES" => "Basque",
    "fa_IR" => "Persian",
    "fb_LT" => "Leet Speak",
    "fi_FI" => "Finnish",
    "fo_FO" => "Faroese",
    "fr_CA" => "French(Canada)",
    "fr_FR" => "French(France)",
    "fy_NL" => "Frisian",
    "ga_IE" => "Irish",
    "gl_ES" => "Galician",
    "gn_PY" => "Guarani",
    "he_IL" => "Hebrew",
    "hi_IN" => "Hindi",
    "hr_HR" => "Croatian",
    "hu_HU" => "Hungarian",
    "hy_AM" => "Armenian",
    "id_ID" => "Indonesian",
    "is_IS" => "Icelandic",
    "it_IT" => "Italian",
    "ja_JP" => "Japanese",
    "jv_ID" => "Javanese",
    "ka_GE" => "Georgian",
    "km_KH" => "Khmer",
    "kn_IN" => "Kannada",
    "ko_KR" => "Korean",
    "ku_TR" => "Kurdish",
    "la_VA" => "Latin",
    "lt_LT" => "Lithuanian",
    "lv_LV" => "Latvian",
    "mk_MK" => "Macedonian",
    "ml_IN" => "Malayalam",
    "ms_MY" => "Malay",
    "nb_NO" => "Norwegian(bokmal)",
    "ne_NP" => "Nepali",
    "nl_NL" => "Dutch",
    "nn_NO" => "Norwegian(nynorsk)",
    "pa_IN" => "Punjabi",
    "pl_PL" => "Polish",
    "ps_AF" => "Pashto",
    "pt_BR" => "Portuguese(Brazil)",
    "pt_PT" => "Portuguese(Portugal)",
    "ro_RO" => "Romanian",
    "ru_RU" => "Russian",
    "si_LK" => "Sinhala",
    "sk_SK" => "Slovak",
    "sl_SI" => "Slovenian",
    "sq_AL" => "Albanian",
    "sr_RS" => "Serbian",
    "sv_SE" => "Swedish",
    "sw_KE" => "Swahili",
    "ta_IN" => "Tamil",
    "te_IN" => "Telugu",
    "th_TH" => "Thai",
    "tl_PH" => "Filipino",
    "tr_TR" => "Turkish",
    "uk_UA" => "Ukrainian",
    "ur_PK" => "Urdu",
    "vi_VN" => "Vietnamese",
    "zh_CN" => "Simplified Chinese (China)",
    "zh_HK" => "Traditional Chinese (Hong Kong)",
    "zh_TW" => "Traditional Chinese (Taiwan)"
);
?>

<div class="wrap">
    <div class="container-fluid">
    <form method="post" name="popup_attributes" id="ays-fpl-form">
    <input type="hidden" name="ays_fb_tab" value="<?php echo $ays_fb_tab; ?>">
    <h1 class="wp-heading-inline">
        <?php
            echo "$heading";
            $other_attributes = array('id' => 'ays-button-top');
            submit_button(__('Save LikeBox', $this->plugin_name), 'primary', 'ays_submit_top', false, $other_attributes);
            submit_button(__('Apply LikeBox', $this->plugin_name), '', 'ays_apply_top', false, $other_attributes);
        ?>
    </h1>
    <h2 class="ays-popup-box-menu-title"><?php echo __(get_admin_page_title()); ?></h2>
    <div class="nav-tab-wrapper">
        <a href="#tab1" data-tab="tab1" class="nav-tab <?php echo ($ays_fb_tab == 'tab1') ? 'nav-tab-active' : ''; ?>"><?php echo __("General", $this->plugin_name); ?></a>
        <a href="#tab3" data-tab="tab3" class="nav-tab <?php echo ($ays_fb_tab == 'tab3') ? 'nav-tab-active' : ''; ?>"><?php echo __("Settings", $this->plugin_name); ?></a>
        <a href="#tab2" data-tab="tab2" class="nav-tab <?php echo ($ays_fb_tab == 'tab2') ? 'nav-tab-active' : ''; ?>"><?php echo __("Styles", $this->plugin_name); ?></a>
    </div>
    <?php
        $contents         = explode( "***", $fblikebox["content"] );
        $header_options   = explode( "***", $fblikebox["header_options"] );
        $onoffswitch      = $fblikebox["onoffswitch"];
        $id != null ? $view_place = explode( "***", $fblikebox['view_place']) : $view_place = [];

    ?>
    <div id="tab1" class="ays-fpl-tab-content <?php echo ($ays_fb_tab == 'tab1') ? 'ays-fpl-tab-content-active' : ''; ?>">
        <p class="ays-subtitle"><?php echo  __('AYS FB LikeBox General Settings', $this->plugin_name) ?></p>
        <hr/>
        <div class="form-group row">
            <div class="col-sm-3">
                <label for="<?php echo $this->plugin_name; ?>-onoffswitch" style="line-height: 50px;">
                    <span><?php echo __('Enable/Disable PopupBox', $this->plugin_name); ?></span>
                    <a class="ays_help" data-toggle="tooltip"
                       title="<?php echo __('This PopupBox is used for showing the PopupBox. Enable: show PopupBox. Disable: do not show PopupBox', $this->plugin_name) ?>">
                       <i class="fas fa-info-circle"></i>
                    </a>
                </label>
            </div>
            <div class="col-sm-9">
                <p class="onoffswitch">
                    <input type="checkbox" name="<?php echo $this->plugin_name; ?>[onoffswitch]" class="onoffswitch-checkbox" id="<?php echo $this->plugin_name; ?>-onoffswitch" <?php if($onoffswitch == 'On'){ echo 'checked';} else { echo '';} ?> />
                </p>
            </div>
        </div>
        <hr/>
        <div class="form-group row">
            <div class="col-sm-3">
                <label for="popup_likebox_guest" style="line-height: 50px;">
                    <span><?php echo __('Enable for guests', $this->plugin_name); ?></span>
                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __( "This field is used for showing the PopupBox for guests.", $this->plugin_name);?>">
                       <i class="fas fa-info-circle"></i>
                   </a>
                </label>
            </div>
            <div class="col-sm-9">
                <p class="onoffswitch">
                    <input type="checkbox" name="<?php echo $this->plugin_name; ?>[popup_likebox_guest]" class="onoffswitch-checkbox" id="popup_likebox_guest" <?php if($show_popup_likebox_guest == 'On'){ echo 'checked';} else { echo '';} ?> />
                </p>
            </div>
        </div>
        <hr/>
        <div class="form-group row">
            <div class="col-sm-3">
                <label for="popup_likebox_logged_users" style="line-height: 50px;">
                    <span><?php echo __('Enable for logged in users', $this->plugin_name); ?></span>
                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __( "This field is used for showing the PopupBox for logged in users.", $this->plugin_name);?>">
                       <i class="fas fa-info-circle"></i>
                   </a>
                </label>
            </div>
            <div class="col-sm-9">
                <p class="onoffswitch">
                    <input type="checkbox" name="<?php echo $this->plugin_name; ?>[popup_likebox_logged_users]" class="onoffswitch-checkbox" id="popup_likebox_logged_users" <?php if($show_popup_likebox_logged_users == 'On'){ echo 'checked';} else { echo '';} ?> />
                </p>
            </div>
        </div>
        <hr/>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label for="ays-fb-mobile" style="line-height: 50px;">
                        <span><?php echo __('Hide LikeBox on mobile', $this->plugin_name); ?></span>
                        <a class="ays_help" data-toggle="tooltip"
                           title="<?php echo __('This field is used for hiding the LikeBox on mobile devices.', $this->plugin_name) ?>">
                            <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9">
                    <p class="onoffswitch">
                        <input type="checkbox" name="ays_fb_mobile" class="onoffswitch-checkbox" id="ays-fb-mobile" value='on' <?php if($fb_mobile == 'on'){ echo 'checked';} else { echo '';} ?> />
                    </p>
                </div>
            </div>                
        <hr/>
        <div class="form-group row">
            <div class="col-sm-3">
                <label for="<?php echo $this->plugin_name; ?>-show_all_yes">
                    <?php echo __('Show on all pages', $this->plugin_name); ?>
                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This parameter is responsible for the display of PopupBox, whether or not the PopupBox is displayed on all pages or not", $this->plugin_name); ?>">
                        <i class="fas fa-info-circle"></i>
                    </a>
                </label>
            </div>
            <div class="col-sm-9">
                <label for="<?php echo $this->plugin_name; ?>-show_all_yes"><?php echo __( "Yes", $this->plugin_name); ?>
                    <input type="radio" name="<?php echo $this->plugin_name; ?>[ays_fb_show_all]" id="<?php echo $this->plugin_name; ?>-show_all_yes" value="yes" <?php echo ($fblikebox['show_all'] == 'yes') ? 'checked' : ''; ?>  />
                </label>
                <label for="<?php echo $this->plugin_name; ?>-show_all_no"><?php echo __( "No", $this->plugin_name); ?>
                    <input type="radio" id="<?php echo $this->plugin_name; ?>-show_all_no" name="<?php echo $this->plugin_name; ?>[ays_fb_show_all]" value="no" <?php echo ($fblikebox['show_all'] == 'no') ? 'checked' : ''; ?> />
                </label>
            </div>
        </div>
        <div class="ays_fpl_view_place_tr ays-field">
        <hr/>
            <label>
                <?php echo  __('Show only ', $this->plugin_name) ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __("With the help of the choice of this field, you can choose in what page PopupBox should be opened", $this->plugin_name); ?>">
                    <i class="fas fa-info-circle"></i>
                </a>
            </label>
            <button type="button" class="ays_view_place_clear button button-small wp-picker-default"><?php echo __( "Clear", $this->plugin_name); ?></button>
            <select id="<?php echo $this->plugin_name; ?>-ays_fb_view_place" multiple="multiple" name="<?php echo $this->plugin_name; ?>[ays_fb_view_place][]">
                <?php
                $args = array(
                    'post_type' => array('post', 'page'),                                    
                    'nopaging'  => true
                );

                // Custom query.
                $query = new WP_Query( $args );

                if($query->have_posts()){
                    foreach ($query->posts as $key => $post){
                        if(in_array($post->ID, $view_place)):
                        ?>
                            <option selected value="<?php echo $post->ID; ?>"><?php echo __( get_the_title($post->ID), $this->plugin_name); ?></option>
                        <?php
                        else:
                        ?>
                            <option value="<?php echo $post->ID; ?>"><?php echo __( get_the_title($post->ID), $this->plugin_name); ?></option>
                        <?php
                        endif;
                    }
                }

                // Restore original post data.
                wp_reset_postdata();

                ?>
            </select>
        </div>
        <hr/>
        <div class="form-group row">
            <div class="col-sm-3">
                <label for="<?php echo $this->plugin_name; ?>-ays_fb_url">
                    <?php  echo __('Facebook page url',$this->plugin_name) ?>
                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __( "With the help of this insert field, it notes Facebook URL address seen in PopupBox", $this->plugin_name); ?>" >
                        <i class="fas fa-info-circle"></i>
                    </a>
                </label>
            </div>
            <div class="col-sm-9">
                <input id="<?php echo $this->plugin_name; ?>-ays_fb_url" class="ays-text-input" name="<?php echo $this->plugin_name; ?>[ays_fb_url]" type="text" value="<?php echo wp_unslash($fblikebox['url']); ?>" />
            </div>
        </div>
        <hr/>
        <div class="form-group row">
            <div class="col-sm-3">
                <label class="description" for="ays_fb_language">
                    <?php echo __('Language',$this->plugin_name) ;?>
                </label>
            </div>
            <div class="col-sm-9">
                <select id="ays_fb_language" class="ays_nk_res" name='ays_fb_language[lang]'>
                    <option>Select Language</option>
                    <?php

                    foreach($ays_lang_arr as $key => $value){
                        $selected = "";
                        if ($fblikebox['lang'] == $key) {
                            $selected = "selected";
                        }
                        echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                    }

                    ?>
                </select>
            </div>
        </div>
        <hr/>
        <div class="form-group row">
            <div class="col-sm-3">
                <label>
                    <?php echo  __('Hide click to action button ',$this->plugin_name) ?>
                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __( "With the help of the choice of this field, it notes whether opened in PopupBox for facebook page is intended for matching the action button to display or not", $this->plugin_name); ?>">
                        <i class="fas fa-info-circle"></i>
                    </a>
                </label>
            </div>
            <div class="col-sm-9">
                <input id="<?php echo $this->plugin_name; ?>-ays_fb_click_to_action_yes" type="radio" value="true" name="<?php echo $this->plugin_name; ?>[ays_fb_click_to_action]" <?php echo ($fblikebox['click_to_action'] == 'true') ? 'checked' : ''; ?>/>
                <label for="<?php echo $this->plugin_name; ?>-ays_fb_click_to_action_yes"><?php echo  __('Yes', $this->plugin_name) ?></label>

                <input id="<?php echo $this->plugin_name; ?>-ays_fb_events_no" type="radio" value="false" name="<?php echo $this->plugin_name; ?>[ays_fb_click_to_action]" <?php echo ($fblikebox['click_to_action'] == 'false') ? 'checked' : ''; ?>/>
                <label for="<?php echo $this->plugin_name; ?>-ays_fb_events_no"><?php echo  __('No', $this->plugin_name) ?></label>
            </div>
        </div>
        <hr/>
        <div class="form-group row">
            <div class="col-sm-3">
                <label>
                    <?php echo  __('Show on', $this->plugin_name) ?>
                    <a class="ays_help" data-toggle="tooltip" data-html='true' title="<?php echo __( "With the help of the choice of this field, you can see the information about Facebook page opened in PopupBox:", $this->plugin_name); echo  "<ul class='ays_help_desc'><li>"; echo __( "Timeline of the page", $this->plugin_name); echo "</li><li>"; echo __( "Events of the page", $this->plugin_name); echo "</li><li>"; echo __( "Messages of the page", $this->plugin_name); echo "</li></ul>"; ?>">
                        <i class="fas fa-info-circle"></i>
                    </a> 
                </label>
            </div>
            <div class="col-sm-9">
                <input id="<?php echo $this->plugin_name; ?>-ays_fb_timeline" name="<?php echo $this->plugin_name; ?>[ays_fb_content][]" type="checkbox" value="timeline" <?php echo (in_array('timeline', wp_unslash($contents))) ? "checked" : ""; ?>/>
                <label for="<?php echo $this->plugin_name; ?>-ays_fb_timeline"><?php  echo __('Timeline',$this->plugin_name) ?></label>

                <input id="<?php echo $this->plugin_name; ?>-ays_fb_events" name="<?php echo $this->plugin_name; ?>[ays_fb_content][]" type="checkbox" value="events" <?php echo (in_array('events', wp_unslash($contents))) ? "checked" : "" ; ?>/>
                <label for="<?php echo $this->plugin_name; ?>-ays_fb_events"><?php  echo __('Events',$this->plugin_name) ?></label>

                <input id="<?php echo $this->plugin_name; ?>-ays_fb_messages" name="<?php echo $this->plugin_name; ?>[ays_fb_content][]" type="checkbox" value="messages" <?php echo (in_array('messages', wp_unslash($contents))) ? "checked" : ""; ?>/>
                <label for="<?php echo $this->plugin_name; ?>-ays_fb_messages"><?php  echo __('Messages',$this->plugin_name) ?></label>
            </div>
        </div>
        <hr/>
        <div class="form-group row">
            <div class="col-sm-3">
                <label>
                    <?php echo  __('Use in FB plugin',$this->plugin_name) ?>
                    <a class="ays_help" data-toggle="tooltip" data-html='true' title="<?php echo __("With the help of the choice of this field, it displays the data used in the Facebook page seen in PopupBox:", $this->plugin_name); echo "<ul class='ays_help_desc'><li>"; echo __("Show a small header", $this->plugin_name); echo "</li><li>"; echo __("Hide cover photos", $this->plugin_name); echo "</li><li>"; echo __("Show friend faces", $this->plugin_name); echo "</li></ul>"; ?>">
                        <i class="fas fa-info-circle"></i>
                    </a> 
                </label>
            </div>
            <div class="col-sm-9">
                <input id="<?php echo $this->plugin_name; ?>-ays_fb_small_header" name="<?php echo $this->plugin_name; ?>[ays_fb_header_options][]" type="checkbox" value="small_header" <?php echo (in_array('small_header', wp_unslash($header_options))) ? "checked" : ""; ?>/>
                <label for="<?php echo $this->plugin_name; ?>-ays_fb_small_header"><?php echo  __('Small header',$this->plugin_name) ?></label>

                <input id="<?php echo $this->plugin_name; ?>-as_fb_hide_cover_photo" name="<?php echo $this->plugin_name; ?>[ays_fb_header_options][]" type="checkbox" value="hide_cover_photo" <?php echo (in_array('hide_cover_photo', wp_unslash($header_options))) ? "checked" : ""; ?>/>
                <label for="<?php echo $this->plugin_name; ?>-as_fb_hide_cover_photo"><?php echo  __('Hide Cover Photoes',$this->plugin_name) ?></label>

                <input id="<?php echo $this->plugin_name; ?>-ays_fb_show_friend_faces" name="<?php echo $this->plugin_name; ?>[ays_fb_header_options][]" type="checkbox" value="show_friend_faces" <?php  echo (in_array('show_friend_faces', wp_unslash($header_options))) ? "checked" : ""; ?>/>
                <label for="<?php echo $this->plugin_name; ?>-ays_fb_show_friend_faces"><?php  echo __('Show Friend Faces',$this->plugin_name) ?></label>
            </div>
        </div>
        <hr/>
        <div class="form-group row">
            <div class="col-sm-3">
                <label for="<?php echo $this->plugin_name; ?>-ays_fb_likebox_title">
                    <?php echo  __('Likebox Title',$this->plugin_name) ?>
                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This field shows the name of the PopupBox", $this->plugin_name); ?>">
                        <i class="fas fa-info-circle"></i>
                    </a>
                </label>
            </div>
            <div class="col-sm-9">
                <input id="<?php echo $this->plugin_name; ?>-ays_fb_likebox_title" class="ays-text-input" name="<?php echo $this->plugin_name; ?>[ays_fb_likebox_title]" type="text" value="<?php echo htmlentities($fblikebox['title']); ?>" />
            </div>
        </div>
        <hr/>
        
        <div class="ays-field">
            <label for="<?php echo $this->plugin_name; ?>-ays_fb_likebox_description">
                <?php echo  __('Likebox Description',$this->plugin_name) ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This field shows the description of the PopupBox", $this->plugin_name); ?>">
                    <i class="fas fa-info-circle"></i>
                </a>
            </label>
            <textarea id="<?php echo $this->plugin_name; ?>-ays_fb_likebox_description" class="ays-textarea" name="<?php echo $this->plugin_name; ?>[ays_fb_likebox_description]"><?php echo htmlentities($fblikebox['description']); ?></textarea>
        </div>
        <div class="pb_position_block form-group row" style="padding: 10px 0;">
            <div class="col-sm-12 only_pro" style="padding: 10px;">
                <div class="pro_features">
                    <div>
                        <p>
                            <?php echo __("This feature is available only in ", $this->plugin_name); ?>
                            <a href="https://ays-pro.com/wordpress/facebook-popup-likebox" target="_blank" title="PRO feature"><?php echo __("PRO version!!!", $this->plugin_name); ?></a>
                        </p>
                    </div>
                </div>
                <div class="form-group row" style="align-items: center;">
                    <div class="col-sm-3">
                        <label for="<?php echo $this->plugin_name; ?>-position">
                            <span><?php echo __('Likebox Position ', $this->plugin_name); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("In what position do you want Likebox to open.", $this->plugin_name); ?>">
                                <i class="fas fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-3">
                        <select id="<?php echo $this->plugin_name; ?>-position" class="ays-text-input">
                            <option id="pb_position_center" selected value="center-center"><?php echo __('Center Center'); ?></option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <table id="ays-fb-position-table">
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td style="background-color: #a2d6e7"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ///////////////////////////////////////////////////////////////// -->
    <div id="tab2" class="ays-fpl-tab-content <?php echo ($ays_fb_tab == 'tab2') ? 'ays-fpl-tab-content-active' : ''; ?>">
        <p class="ays-subtitle"><?php  echo __('AYS Facebook Popoup Likebox Styles', $this->plugin_name) ?></p>
        <hr/>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for='ays-fb-bg-image'>
                            <?= __('Background Image', $this->plugin_name); ?>
                            <a class="ays_help" data-toggle="tooltip" data-placement="top"
                               title="<?= __("Background image of the popupbox", $this->plugin_name); ?>">
                                <i class="ays_fa ays_fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <a href="javascript:void(0)" class="button ays-fb-add-bg-image">
                            <?php echo $image_text_bg; ?>
                            <a class="ays_help" data-toggle="tooltip" data-placement="top"
                               title="<?= __("If you add background image, background color not be applied. Remove image or don't add it, if you want background color will be apply", $this->plugin_name); ?>">
                                <i class="fas fa-info-circle"></i>
                            </a>
                        </a>
                    </div>
                </div>
                <div class="col-sm-8" style="<?php echo $style_bg; ?>">
                    <div class="ays-fb-bg-image-container">
                        <span class="ays-remove-bg-img"></span>
                        <img src="<?php echo $bg_image ?>" id="ays-fb-bg-img"/>
                        <input type="hidden" name="ays_fb_bg_image" id="ays-fb-bg-image"
                               value="<?php echo $bg_image ?>"/>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="<?php echo $this->plugin_name; ?>-ays_fb_bgcolor">
                            <?php echo  __('PopupBox background color: ',$this->plugin_name) ?>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This field notes PopupBox background color", $this->plugin_name); ?>">
                                <i class="fas fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <input id="<?php echo $this->plugin_name; ?>-ays_fb_bgcolor" type="text" class="ays_fpl_color_input ays_fpl_bgcolor_change" name="<?php echo $this->plugin_name; ?>[ays_fb_bgcolor]" value="<?php echo wp_unslash($fblikebox['bgcolor']); ?>" data-default-color="#FFFFFF">
                    </div>
                </div>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="<?php echo $this->plugin_name; ?>-ays_fb_textcolor">
                            <?php echo  __('PopupBox text color: ',$this->plugin_name) ?>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("With the help of this field, you can see the text color of PopupBox", $this->plugin_name); ?>">
                                <i class="fas fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <input id="<?php echo $this->plugin_name; ?>-ays_fb_textcolor" type="text" class="ays_fpl_color_input ays_fpl_textcolor_change" name="<?php echo $this->plugin_name; ?>[ays_fb_textcolor]" value="<?php echo wp_unslash($fblikebox['textcolor']); ?>" data-default-color="#000000">
                    </div>
                </div>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="<?php echo $this->plugin_name; ?>-ays_fb_bordercolor">
                            <?php echo  __('PopupBox border color: ',$this->plugin_name) ?>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This field notes the border color of the PopupBox", $this->plugin_name); ?>">
                                <i class="fas fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <input id="<?php echo $this->plugin_name; ?>-ays_fb_bordercolor" type="text" class="ays_fpl_color_input ays_fpl_bordercolor_change" name="<?php echo $this->plugin_name; ?>[ays_fb_bordercolor]" value="<?php echo wp_unslash($fblikebox['bordercolor']); ?>" data-default-color="#FFFFFF">
                    </div>
                </div>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="<?php echo $this->plugin_name; ?>-ays_fb_bordersize">
                            <?php echo  __('PopupBox border size: ',$this->plugin_name) ?>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This field notes the border size of the PopupBox", $this->plugin_name); ?>">
                                <i class="fas fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <input id="<?php echo $this->plugin_name; ?>-ays_fb_bordersize" class="ays-text-input-short" type="number" name="<?php echo $this->plugin_name; ?>[ays_fb_bordersize]" value="<?php echo wp_unslash($fblikebox['bordersize']); ?>">
                    </div>
                </div>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="<?php echo $this->plugin_name; ?>-ays_fb_fontsize_title">
                            <?php echo  __('PopupBox Title font size: ',$this->plugin_name) ?>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This field notes the font size of the PopupBox Title", $this->plugin_name); ?>">
                                <i class="fas fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <input id="<?php echo $this->plugin_name; ?>-ays_fb_fontsize_title" class="ays-text-input-short" type="number" name="<?php echo $this->plugin_name; ?>[ays_fb_fontize_title]" value="<?php echo wp_unslash($title_fontsize); ?>">
                    </div>
                </div>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="<?php echo $this->plugin_name; ?>-ays_fb_fontsize_description">
                            <?php echo  __('PopupBox Description font size: ',$this->plugin_name) ?>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This field notes the font size of the PopupBox Description", $this->plugin_name); ?>">
                                <i class="fas fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <input id="<?php echo $this->plugin_name; ?>-ays_fb_fontsize_description" class="ays-text-input-short" type="number" name="<?php echo $this->plugin_name; ?>[ays_fb_fontize_description]" value="<?php echo wp_unslash($description_fontsize); ?>">
                    </div>
                </div>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="<?php echo $this->plugin_name; ?>-ays_fb_border_radius">
                            <?php echo  __('PopupBox border radius: ',$this->plugin_name) ?>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This field notes the border radius of the PopupBox", $this->plugin_name); ?>">
                                <i class="fas fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <input id="<?php echo $this->plugin_name; ?>-ays_fb_border_radius" class="ays-text-input-short" type="number" name="<?php echo $this->plugin_name; ?>[ays_fb_border_radius]" value="<?php echo wp_unslash($fblikebox['border_radius']); ?>">
                    </div>
                </div>
                <hr/>
                  <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="<?php echo $this->plugin_name; ?>-ays_fb_width">
                            <?php echo  __('Width',$this->plugin_name) ?>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This field provides information of PopupBox width with pixels", $this->plugin_name); ?>">
                                <i class="fas fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <input id="<?php echo $this->plugin_name; ?>-ays_fb_width" class="ays-text-input-short" name="<?php echo $this->plugin_name; ?>[ays_fb_width]" type="number" value="<?php echo $fblikebox['width']; ?>" />
                    </div>
                </div>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="<?php echo $this->plugin_name; ?>-mobile_max_width">
                            <?php echo  __('PopupBox max-width for mobile',$this->plugin_name) ?>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("PopupBox container max-width for mobile in percentage. This option will work for the screens with less than 640 pixels width.", $this->plugin_name); ?>">
                                <i class="fas fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <input id="<?php echo $this->plugin_name; ?>-mobile_max_width" class="ays-text-input-short" name="<?php echo $this->plugin_name; ?>[mobile_max_width]" type="number" style="display:inline-block;" value="<?php echo $mobile_max_width; ?>" /> %
                         <span style="display:block;" class="ays_fb_small_hint_text"><?php echo __("For 100% leave blank", $this->plugin_name);?></span>
                    </div>
                </div>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="<?php echo $this->plugin_name; ?>-ays_fb_height">
                            <?php echo  __('Height',$this->plugin_name) ?>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This field provides information of PopupBox height with pixels", $this->plugin_name); ?>">
                                <i class="fas fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <input id="<?php echo $this->plugin_name; ?>-ays_fb_height" class="ays-text-input-short" name="<?php echo $this->plugin_name; ?>[ays_fb_height]" type="number" value="<?php echo $fblikebox['height']; ?>" />
                    </div>
                </div>

                <hr/>
                <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="ays_fbl_font_family">
                                    <?php echo  __('Font family',$this->plugin_name) ?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Choose your preferred font family from the suggested variants for the Popup Likebox.", $this->plugin_name); ?>">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-6">
                                <select id="ays_fbl_font_family" class="" name="ays_fbl_font_family">
                                <?php
                                    $selected  = "";
                                    foreach ($font_families as $key => $fbl_font_family) {
                                        if(is_array($fbl_font_family)){
                                            if (in_array($font_family_option,$fbl_font_family)) {
                                               $selected = "selected";
                                            }
                                            else{
                                                $selected = "";
                                            }
                                        }else{
                                            if($fbl_font_family == $font_family_option){
                                                $selected = "selected";
                                            }else{
                                                $selected = "";
                                            }
                                        }
                                    
                                ?>
                                    <option value="<?php echo $fbl_font_family ;?>" <?php echo $selected ;?>>
                                        <?php echo $fbl_font_family; ?>
                                    </option>

                                <?php
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="<?php echo $this->plugin_name; ?>-ays_fb_animation_in">
                            <?php echo  __('Box show effect: ',$this->plugin_name) ?>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This field notes that with what animation the PopupBox should be opened", $this->plugin_name); ?>">
                                <i class="fas fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <select class="animation_effects" id="<?php echo $this->plugin_name; ?>-ays_fb_animation_in" name="<?php echo $this->plugin_name; ?>[ays_fb_animation_in]">                                
                            <optgroup label="Fading Entrances">
                                <option <?php echo 'fadeIn' == $fblikebox['animate_in'] ? 'selected' : ''; ?> value="fadeIn">Fade In</option>
                                <option <?php echo 'fadeInDown' == $fblikebox['animate_in'] ? 'selected' : ''; ?> value="fadeInDown">Fade In Down</option>
                                <option <?php echo 'fadeInDownBig' == $fblikebox['animate_in'] ? 'selected' : ''; ?> value="fadeInDownBig">Fade In Down Big</option>
                                <option <?php echo 'fadeInLeft' == $fblikebox['animate_in'] ? 'selected' : ''; ?> value="fadeInLeft">Fade In Left</option>
                                <option <?php echo 'fadeInLeftBig' == $fblikebox['animate_in'] ? 'selected' : ''; ?> value="fadeInLeftBig">Fade In Left Big</option>
                                <option <?php echo 'fadeInRight' == $fblikebox['animate_in'] ? 'selected' : ''; ?> value="fadeInRight">Fade In Right</option>
                                <option <?php echo 'fadeInRightBig' == $fblikebox['animate_in'] ? 'selected' : ''; ?> value="fadeInRightBig">Fade In Right Big</option>
                                <option <?php echo 'fadeInUp' == $fblikebox['animate_in'] ? 'selected' : ''; ?> value="fadeInUp">Fade In Up</option>
                                <option <?php echo 'fadeInUpBig' == $fblikebox['animate_in'] ? 'selected' : ''; ?> value="fadeInUpBig">Fade In Up Big</option>
                            </optgroup>
                            <optgroup label="Bouncing Entrances">
                                <option <?php echo 'bounceIn' == $fblikebox['animate_in'] ? 'selected' : ''; ?> value="bounceIn">Bounce In</option>
                                <option <?php echo 'bounceInDown' == $fblikebox['animate_in'] ? 'selected' : ''; ?> value="bounceInDown">Bounce In Down</option>
                                <option <?php echo 'bounceInLeft' == $fblikebox['animate_in'] ? 'selected' : ''; ?> value="bounceInLeft">Bounce In Left</option>
                                <option <?php echo 'bounceInRight' == $fblikebox['animate_in'] ? 'selected' : ''; ?> value="bounceInRight">Bounce In Right</option>
                                <option <?php echo 'bounceInUp' == $fblikebox['animate_in'] ? 'selected' : ''; ?> value="bounceInUp">Bounce In Up</option>
                            </optgroup>
                            <optgroup label="Sliding Entrances">
                                <option <?php echo 'slideInUp' == $fblikebox['animate_in'] ? 'selected' : ''; ?> value="slideInUp">Slide In Up</option>
                                <option <?php echo 'slideInDown' == $fblikebox['animate_in'] ? 'selected' : ''; ?> value="slideInDown">Slide In Down</option>
                                <option <?php echo 'slideInLeft' == $fblikebox['animate_in'] ? 'selected' : ''; ?> value="slideInLeft">Slide In Left</option>
                                <option <?php echo 'slideInRight' == $fblikebox['animate_in'] ? 'selected' : ''; ?> value="slideInRight">Slide In Right</option> 
                            </optgroup>
                            <optgroup label="Zoom Entrances">
                                <option <?php echo 'zoomIn' == $fblikebox['animate_in'] ? 'selected' : ''; ?> value="zoomIn">Zoom In</option> 
                                <option <?php echo 'zoomInDown' == $fblikebox['animate_in'] ? 'selected' : ''; ?> value="zoomInDown">Zoom In Down</option> 
                                <option <?php echo 'zoomInLeft' == $fblikebox['animate_in'] ? 'selected' : ''; ?> value="zoomInLeft">Zoom In Left</option> 
                                <option <?php echo 'zoomInRight' == $fblikebox['animate_in'] ? 'selected' : ''; ?> value="zoomInRight">Zoom In Right</option> 
                                <option <?php echo 'zoomInUp' == $fblikebox['animate_in'] ? 'selected' : ''; ?> value="zoomInUp">Zoom In Up</option> 
                            </optgroup>
                            <optgroup label="Rotating Entrances">
                                <option <?php echo 'rotateIn' == $fblikebox['animate_in'] ? 'selected' : ''; ?> value="rotateIn">Rotate In</option> 
                                <option <?php echo 'rotateInDownLeft' == $fblikebox['animate_in'] ? 'selected' : ''; ?> value="rotateInDownLeft">Rotating In Down Left</option> 
                                <option <?php echo 'rotateInDownRight' == $fblikebox['animate_in'] ? 'selected' : ''; ?> value="rotateInDownRight">Rotating In Down Right</option> 
                                <option <?php echo 'rotateInUpLeft' == $fblikebox['animate_in'] ? 'selected' : ''; ?> value="rotateInUpLeft">Rotating In Up Left</option> 
                                <option <?php echo 'rotateInUpRight' == $fblikebox['animate_in'] ? 'selected' : ''; ?> value="rotateInUpRight">Rotating In Up Right</option> 
                            </optgroup>
                            <optgroup label="Fliping Entrances">
                                <option <?php echo 'flipInY' == $fblikebox['animate_in'] ? 'selected' : ''; ?> value="flipInY">Flip In Y</option> 
                                <option <?php echo 'flipInX' == $fblikebox['animate_in'] ? 'selected' : ''; ?> value="flipInX">Flip In X</option> 
                            </optgroup>                
                        </select>
                    </div>
                </div>
                <hr/>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="<?php echo $this->plugin_name; ?>-ays_fb_animation_out">
                            <?php echo  __('Box hide effect: ',$this->plugin_name) ?>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This field notes that with what animation the PopupBox should be closed", $this->plugin_name); ?>">
                                <i class="fas fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <select class="animation_effects" id="<?php echo $this->plugin_name; ?>-ays_fb_animation_out" name="<?php echo $this->plugin_name; ?>[ays_fb_animation_out]">
                            <optgroup label="Fading Exits">
                                <option <?php echo  $fblikebox['animate_out'] == 'fadeOut' ? 'selected' : ''; ?> value="fadeOut">Fade Out</option>
                                <option <?php echo  $fblikebox['animate_out'] == 'fadeOut' ? 'selected' : ''; ?> value="fadeOutDown">Fade Out Down</option>
                                <option <?php echo  $fblikebox['animate_out'] == 'fadeOut' ? 'selected' : ''; ?> value="fadeOutDownBig">Fade Out Down Big</option>
                                <option <?php echo  $fblikebox['animate_out'] == 'fadeOut' ? 'selected' : ''; ?> value="fadeOutLeft">Fade Out Left</option>
                                <option <?php echo  $fblikebox['animate_out'] == 'fadeOut' ? 'selected' : ''; ?> value="fadeOutLeftBig">Fade Out Left Big</option>
                                <option <?php echo  $fblikebox['animate_out'] == 'fadeOut' ? 'selected' : ''; ?> value="fadeOutRight">Fade Out Right</option>
                                <option <?php echo  $fblikebox['animate_out'] == 'fadeOut' ? 'selected' : ''; ?> value="fadeOutRightBig">Fade Out Right Big</option>
                                <option <?php echo  $fblikebox['animate_out'] == 'fadeOut' ? 'selected' : ''; ?> value="fadeOutUp">Fade Out Up</option>
                                <option <?php echo  $fblikebox['animate_out'] == 'fadeOut' ? 'selected' : ''; ?> value="fadeOutUpBig">Fade Out Up Big</option>
                            </optgroup>
                            <optgroup label="Bouncing Exits">
                                <option <?php echo 'bounceOut' == $fblikebox['animate_out'] ? 'selected' : ''; ?> value="bounceOut">Bounce Out</option>
                                <option <?php echo 'bounceOutDown' == $fblikebox['animate_out'] ? 'selected' : ''; ?> value="bounceOutDown">Bounce Out Down</option>
                                <option <?php echo 'bounceOutLeft' == $fblikebox['animate_out'] ? 'selected' : ''; ?> value="bounceOutLeft">Bounce Out Left</option>
                                <option <?php echo 'bounceOutRight' == $fblikebox['animate_out'] ? 'selected' : ''; ?> value="bounceOutRight">Bounce Out Right</option>
                                <option <?php echo 'bounceOutUp' == $fblikebox['animate_out'] ? 'selected' : ''; ?> value="bounceOutUp">Bounce Out Up</option>
                            </optgroup>
                            <optgroup label="Sliding Exits">
                                <option <?php echo 'slideOutUp' == $fblikebox['animate_out'] ? 'selected' : ''; ?> value="slideOutUp">Slide Out Up</option>
                                <option <?php echo 'slideOutDown' == $fblikebox['animate_out'] ? 'selected' : ''; ?> value="slideOutDown">Slide Out Down</option>
                                <option <?php echo 'slideOutLeft' == $fblikebox['animate_out'] ? 'selected' : ''; ?> value="slideOutLeft">Slide Out Left</option>
                                <option <?php echo 'slideOutRight' == $fblikebox['animate_out'] ? 'selected' : ''; ?> value="slideOutRight">Slide Out Right</option> 
                            </optgroup>
                            <optgroup label="Zoom Exits">
                                <option <?php echo 'zoomOut' == $fblikebox['animate_out'] ? 'selected' : ''; ?> value="zoomOut">Zoom Out</option> 
                                <option <?php echo 'zoomOutDown' == $fblikebox['animate_out'] ? 'selected' : ''; ?> value="zoomOutDown">Zoom Out Down</option> 
                                <option <?php echo 'zoomOutLeft' == $fblikebox['animate_out'] ? 'selected' : ''; ?> value="zoomOutLeft">Zoom Out Left</option> 
                                <option <?php echo 'zoomOutRight' == $fblikebox['animate_out'] ? 'selected' : ''; ?> value="zoomOutRight">Zoom Out Right</option> 
                                <option <?php echo 'zoomOutUp' == $fblikebox['animate_out'] ? 'selected' : ''; ?> value="zoomOutUp">Zoom Out Up</option> 
                            </optgroup>
                            <optgroup label="Rotating Exits">
                                <option <?php echo 'rotateOut' == $fblikebox['animate_out'] ? 'selected' : ''; ?> value="rotateOut">Rotate Out</option> 
                                <option <?php echo 'rotateOutDownLeft' == $fblikebox['animate_out'] ? 'selected' : ''; ?> value="rotateOutDownLeft">Rotating Out Down Left</option> 
                                <option <?php echo 'rotateOutDownRight' == $fblikebox['animate_out'] ? 'selected' : ''; ?> value="rotateOutDownRight">Rotating Out Down Right</option> 
                                <option <?php echo 'rotateOutUpLeft' == $fblikebox['animate_out'] ? 'selected' : ''; ?> value="rotateOutUpLeft">Rotating Out Up Left</option> 
                                <option <?php echo 'rotateOutUpRight' == $fblikebox['animate_out'] ? 'selected' : ''; ?> value="rotateOutUpRight">Rotating Out Up Right</option> 
                            </optgroup>
                            <optgroup label="Fliping Exits">
                                <option <?php echo 'flipOutY' == $fblikebox['animate_out'] ? 'selected' : ''; ?> value="flipOutY">Flip Out Y</option> 
                                <option <?php echo 'flipOutX' == $fblikebox['animate_out'] ? 'selected' : ''; ?> value="flipOutX">Flip Out X</option> 
                            </optgroup>
                        </select>
                    </div>
                </div>
                <!-- Aro Custom CSS Start  -->
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="custom_class">
                            <?php echo __('Custom class for Popup Box container',$this->plugin_name)?>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Custom HTML class for Popup Box container. You can use your class for adding your custom styles for Popup Box container.',$this->plugin_name)?>">
                                <i class="fas fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="ays-text-input-short" name="<?php echo $this->plugin_name; ?>[custom-class]" id="custom_class" placeholder="myClass myAnotherClass..." value="<?php echo $custom_class; ?>">
                        <!-- ays-text-input  - input Class -->
                        <!--  ays_divider_left  - input-i Div-i Class left border-i hamar-->
                    </div>
                </div>
                <hr>
                <!--Aro End  -->
                <div class="ays-field">
                    <label for="ays_fbl_custom_css">
                        <?php echo  __('Custom Css:',$this->plugin_name) ?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This field notes that how CSS design you can give to PopupBox", $this->plugin_name); ?>">
                            <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                    <textarea id="ays_fbl_custom_css" class="ays-textarea" name="<?php echo $this->plugin_name; ?>[ays_fb_custom_css]" type="text"><?php echo (isset($fblikebox['custom_css']) && $fblikebox['custom_css'] != '') ? wp_unslash(htmlentities($fblikebox['custom_css'])) : '' ?></textarea>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="likebox_preview">
                    <p style="font-weight: normal; font-style: italic; font-size: 14px; color: grey; margin:0; padding:0;"><?php echo __("See PopupBox in live preview", $this->plugin_name); ?></p>
                    <div class='ays-fpl-modals'>
                        <input type='hidden' id='ays_fpl_modal_animate_in'>
                        <input type='hidden' id='ays_fpl_modal_animate_out'>
                        <input id='ays-fpl-modal-checkbox' class='ays-fpl-modal-check' type='checkbox' checked/>
                        <div class='ays-fpl-modal ays_bg_image_box' id='ays-fpl-modal' >
                            <label class='ays-fpl-modal-close'><i class='fa fa-times fa-2x'></i></label>
                            <h2></h2>
                            <p class="desc"></p>
                            <hr />
                            <div class="ays_modal_content"><span><?php echo __("Here your Facebook content", $this->plugin_name); ?></span></div>
                            <p><span><?php echo __("This will close in X seconds", $this->plugin_name); ?></span></p>
                        </div>
                        <div id='ays-fpl-screen-shade'></div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <!-- ////////////////////////////// -->
    <div id="tab3" class="ays-fpl-tab-content <?php echo ($ays_fb_tab == 'tab3') ? 'ays-fpl-tab-content-active' : ''; ?>">
        <p class="ays-subtitle"><?php  echo __('AYS PopupBox Settings', $this->plugin_name) ?></p>
        <hr/>
        <div class="form-group row">
            <div class="col-sm-3">
                <label>
                    <?php echo __("Show LikeBox head", $this->plugin_name);?>
                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Enable to show the Likebox title and description in the start (in the front-end).", $this->plugin_name); ?>">
                        <i class="fas fa-info-circle"></i>
                    </a>
                </label>
            </div>
            <div class="col-sm-9">
                <label for="show_popup_likebox_title">
                    <?php echo __("Show Likebox title", $this->plugin_name);?>
                    <input type="checkbox" class="" id='show_popup_likebox_title'  name="<?php echo $this->plugin_name; ?>[show_popup_likebox_title]" <?php if($show_popup_likebox_title == 'On'){ echo 'checked';} else { echo '';} ?>/>
                </label>
                <label for="show_popup_likebox_description">
                    <?php echo __("Show Likebox description", $this->plugin_name);?>
                    <input type="checkbox" class="" id='show_popup_likebox_description'  name="<?php echo $this->plugin_name; ?>[show_popup_likebox_description]" <?php if($show_popup_likebox_description == 'On'){ echo 'checked';} else { echo '';} ?>/>
                </label>
            </div>
            <div class="col-sm-9">
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-sm-3">
                <label for="ays_fb_show_only_once" style="line-height: 50px;">
                    <span><?php echo __('Show LikeBox only once', $this->plugin_name); ?></span>
                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Enable this field, if you want to show LikeBox only once per user.', $this->plugin_name); ?>">
                        <i class="fas fa-info-circle"></i>
                    </a>
                </label>
            </div>
            <div class="col-sm-9">
                <p class="onoffswitch">
                    <input type="checkbox" name="ays_fb_show_only_once" class="onoffswitch-checkbox" id="ays_fb_show_only_once" <?php echo ($show_only_once == 'on') ? 'checked' : '' ?> >
                </p>
            </div>
        </div>
        <hr/>
        <div class="form-group row">
            <div class="col-sm-3">
                <label for="ays_fb_onoffoverlay">
                    <span><?php echo __('Enable Overlay', $this->plugin_name); ?></span>
                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __("Enable to show the overlay outside of the popup likebox.", $this->plugin_name); ?>">
                        <i class="ays_fa ays_fa-info-circle"></i>
                    </a>
                </label>
            </div>
            <div class="col-sm-9">
                <p class="onoffswitch">
                    <input type="checkbox" name="ays_fb_onoffoverlay" class="onoffswitch-checkbox" id="ays_fb_onoffoverlay" <?php if($onoffoverlay == 'on'){ echo 'checked';} else { echo '';} ?> >
                </p>
            </div>
        </div>
        <hr/>
          <!-- close overlay by esc key start -->
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="ays_close_fbl_esc" style="line-height: 50px;">
                            <span><?php echo __('Close by pressing ESC', $this->plugin_name); ?></span>
                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __("If the option is enabled, the user can close the popup likebox by pressing the ESC button from the keyboard.", $this->plugin_name); ?>">
                                <i class="fas fa-info-circle"></i>
                            </a>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <p class="onoffswitch">
                            <input type="checkbox" name="close_fbl_esc" class="onoffswitch-checkbox" id="ays_close_fbl_esc" <?php if($close_fbl_esc == 'off'){ echo '';} else { echo 'checked';} ?>/>
                        </p>
                    </div>
                </div>
                <!-- close overlay by esc key end -->
        <hr/>
        <div class="form-group row">
            <div class="col-sm-3">
                <label for="<?php echo $this->plugin_name; ?>-ays_fb_autoclose">
                    <?php echo  __('Auto close per seconds',$this->plugin_name) ?>
                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This section shows that after how many seconds the PopupBox will be closed. Set 0 for disable close timeout", $this->plugin_name); ?>">
                        <i class="fas fa-info-circle"></i>
                    </a>                                
                </label>
            </div>
            <div class="col-sm-9">
                <input id="<?php echo $this->plugin_name; ?>-ays_fb_autoclose" class="ays-text-input-short" name="<?php echo $this->plugin_name; ?>[ays_fb_autoclose]" type="number" value="<?php echo $fblikebox['autoclose']; ?>"/>
            </div>
        </div>
        <hr/>
        <div class="form-group row">
            <div class="col-sm-3">
                <label for="<?php echo $this->plugin_name; ?>-ays_fb_delay">
                    <?php echo  __('Delay ',$this->plugin_name) ?>
                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This section shows how many milliseconds delay the PopupBox should be opened", $this->plugin_name); ?>">
                        <i class="fas fa-info-circle"></i>
                    </a>
                </label>
            </div>
            <div class="col-sm-9">
                <input id="<?php echo $this->plugin_name; ?>-ays_fb_delay" type="number" class="ays-text-input-short" value="<?php echo $fblikebox['delay']; ?>" name="<?php echo $this->plugin_name; ?>[ays_fb_delay]"/>
            </div>
        </div>
        <hr/>    
        <div class="form-group row">
            <div class="col-sm-3">
                <label for="<?php echo $this->plugin_name; ?>-ays_fb_scroll_top">
                    <?php echo  __('Show after scroll from top(px) ',$this->plugin_name) ?>
                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This field notes after how many scrolls from the top (px) the PopupBox should be opened", $this->plugin_name); ?>">
                        <i class="fas fa-info-circle"></i>
                    </a>
                </label>
            </div>
            <div class="col-sm-9">
                <input id="<?php echo $this->plugin_name; ?>-ays_fb_scroll_top" type="number" class="ays-text-input-short" value="<?php echo $fblikebox['scroll_top']; ?>" name="<?php echo $this->plugin_name; ?>[ays_fb_scroll_top]"/>
            </div>
        </div>
        <hr/>
        <div class="form-group row">
            <div class="col-sm-3">
                <label>
                    <?php echo __("Show promoter every 'X' minutes",$this->plugin_name) ?>
                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __("This field notes that how many minutes PopupBox will be opened again, to reset cookie set 0", $this->plugin_name); ?>">
                        <i class="fas fa-info-circle"></i>
                    </a>
                </label>
            </div>
            <div class="col-sm-9">
                <label for="<?php echo $this->plugin_name; ?>-ays_fb_cookie"></label>
                <input id="<?php echo $this->plugin_name; ?>-ays_fb_cookie" class="ays-text-input-short" name="<?php echo $this->plugin_name; ?>[ays_fb_cookie]" type="number" value="<?php echo $fblikebox['cookie']; ?>" />
            </div>
        </div>
    </div>
    <div style="clear:both;" ></div>
    <hr/>
    <?php
wp_nonce_field('fblb_action', 'fblb_action');
$other_attributes = array('id' => 'ays-button');
submit_button(__('Save LikeBox', $this->plugin_name), 'primary', 'ays_submit', false, $other_attributes);

submit_button(__('Apply LikeBox', $this->plugin_name), '', 'ays_apply', false, $other_attributes);
?>
    </form>
</div>
<script>
    jQuery(document).ready(function(){
        if(jQuery("#<?php echo $this->plugin_name; ?>-show_all_no").hasAttr = 'checked' && jQuery("#<?php echo $this->plugin_name; ?>-show_all_no").prop('checked')){
            jQuery('.ays_fpl_view_place_tr').show(250);
        }
        if(jQuery("#<?php echo $this->plugin_name; ?>-show_all_yes").hasAttr = 'checked' && jQuery("#<?php echo $this->plugin_name; ?>-show_all_yes").prop('checked')){
            jQuery('.ays_fpl_view_place_tr').hide(250);
        }
    });
    jQuery("#<?php echo $this->plugin_name; ?>-show_all_no").on('click', function(){
        jQuery('.ays_fpl_view_place_tr').show(250);
    });
    jQuery("#<?php echo $this->plugin_name; ?>-show_all_yes").on('click', function(){
        jQuery('.ays_fpl_view_place_tr').hide(250);
    });
</script>
<script>
    (function ($) {
        var a = $('.ays_help_desc');
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
       
        $('.ays-fpl-modal .desc').html($("#<?php echo $this->plugin_name; ?>-ays_fb_likebox_description").val());
        $('.ays-fpl-modal > h2').html($("#<?php echo $this->plugin_name; ?>-ays_fb_likebox_title").val());
        
        $(document).find("#<?php echo $this->plugin_name; ?>-ays_fb_likebox_title").on('change', function(){
            $('.ays-fpl-modal > h2').html($("#<?php echo $this->plugin_name; ?>-ays_fb_likebox_title").val());
        });
        $(document).find("#<?php echo $this->plugin_name; ?>-ays_fb_likebox_description").on('change', function(){
            $('.ays-fpl-modal .desc').html($("#<?php echo $this->plugin_name; ?>-ays_fb_likebox_description").val());
        });

        $(document).find('.ays_bg_image_box').css({
            'background-image' : 'url(' + $("#ays-fb-bg-image").val() + ')',
            'background-repeat' : 'no-repeat',
            'background-size' : 'cover',
            'background-position' : 'center center'
        });
        
        var optionsForBgColor = {
            change: function(e){
                setTimeout(function () {
                    $('.ays-fpl-modal').css('background-color', e.target.value);
                }, 1);
            }
        }
        $(document).find('.ays_fpl_bgcolor_change').wpColorPicker(optionsForBgColor);
        
        var optionsForTextColor = {
            change: function(e){
                setTimeout(function () {
                    $('.ays-fpl-modal').css('color', e.target.value+" !important");
                }, 1);
            }
        }
        $(document).find('.ays_fpl_textcolor_change').wpColorPicker(optionsForTextColor);
        
        var optionsForBorderColor = {
            change: function (e) {
                setTimeout(function () {
                     $('.ays-fpl-modal').css('border-color', e.target.value);
                }, 1);
            }
        }
        $(document).find('.ays_fpl_bordercolor_change').wpColorPicker(optionsForBorderColor);
        
        $(document).find("#<?php echo $this->plugin_name; ?>-ays_fb_textcolor").on('change', function(){
            $('.ays-fpl-modal').css('color', $("#<?php echo $this->plugin_name; ?>-ays_fb_textcolor").val()+' !important');
        });
        $(document).find("#<?php echo $this->plugin_name; ?>-ays_fb_bordersize").on('change', function(){
            $('.ays-fpl-modal').css('border', $("#<?php echo $this->plugin_name; ?>-ays_fb_bordersize").val()+"px solid "+$("#<?php echo $this->plugin_name; ?>-ays_fb_bordercolor").val());
        });

        $(document).find("#ays_fbl_font_family").on('change', function(){
            $('.ays-fpl-modal').css('font-family', $("#ays_fbl_font_family").val());
        });

        $(document).find("#<?php echo $this->plugin_name; ?>-ays_fb_fontsize_title").on('change', function(){
           var title = $("#<?php echo $this->plugin_name; ?>-ays_fb_fontsize_title").val();
            if(parseInt(title) < 0){
               $("#<?php echo $this->plugin_name; ?>-ays_fb_fontsize_title").val(Math.abs(title));
            }else{
                $('#ays-fpl-modal>h2').css('font-size', parseInt(title) +"px");
            }
        });

        $(document).find("#<?php echo $this->plugin_name; ?>-ays_fb_fontsize_description").on('change', function(){
            var description = $("#<?php echo $this->plugin_name; ?>-ays_fb_fontsize_description").val();
            if(parseInt(description) < 0){
               $("#<?php echo $this->plugin_name; ?>-ays_fb_fontsize_description").val(Math.abs(description));
            }else{
                $('#ays-fpl-modal>.desc').css('font-size', parseInt(description) + "px");
            }
        });
        $(document).find("#<?php echo $this->plugin_name; ?>-ays_fb_border_radius").on('change', function(){
            $('.ays-fpl-modal').css('border-radius', $("#<?php echo $this->plugin_name; ?>-ays_fb_border_radius").val()+'px');
        });
        $(document).find("#<?php echo $this->plugin_name; ?>-ays_fb_animation_in").on('change', function(){
            $('.ays-fpl-modal').css('animation', $("#<?php echo $this->plugin_name; ?>-ays_fb_animation_in").val()+" .5s");
        });
        $(document).find("#<?php echo $this->plugin_name; ?>-ays_fb_animation_out").on('change', function(){
            $('.ays-fpl-modal').css('animation', $("#<?php echo $this->plugin_name; ?>-ays_fb_animation_out").val()+" .5s");
        });
        $(document).find("#<?php echo $this->plugin_name; ?>-ays_fb_bordercolor").on('change', function(){
            $('.ays-fpl-modal').css('border', $("#<?php echo $this->plugin_name; ?>-ays_fb_bordersize").val()+"px solid "+$("#<?php echo $this->plugin_name; ?>-ays_fb_bordercolor").val());
        });
        $(document).find('#ays-fpl-modal').css({'background-color': $("#<?php echo $this->plugin_name; ?>-ays_fb_bgcolor").val()});
        $(document).find('#ays-fpl-modal').css({'color': $("#<?php echo $this->plugin_name; ?>-ays_fb_textcolor").val()+' !important'});
        $(document).find('#ays-fpl-modal').css({'border': $("#<?php echo $this->plugin_name; ?>-ays_fb_bordersize").val()+"px solid "+$("#<?php echo $this->plugin_name; ?>-ays_fb_bordercolor").val()});
        $(document).find('#ays-fpl-modal').css({'border-radius': $("#<?php echo $this->plugin_name; ?>-ays_fb_border_radius").val()+'px'});
        $(document).find('#ays-fpl-modal').css({'font-family': $("#ays_fbl_font_family").val()});

    });
    })(jQuery)
</script>
