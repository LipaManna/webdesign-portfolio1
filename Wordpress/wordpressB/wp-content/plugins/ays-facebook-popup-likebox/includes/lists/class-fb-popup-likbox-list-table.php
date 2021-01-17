<?php
ob_start();
class FB_Popup_Likebox_List_Table extends WP_List_Table {
    private $plugin_name;
    /** Class constructor */
    public function __construct($plugin_name) {
        $this->plugin_name = $plugin_name;
        parent::__construct([
            "singular" => __("Facebook LikeBox", $this->plugin_name), //singular name of the listed records
            "plural" => __("Facebook LikeBoxes", $this->plugin_name), //plural name of the listed records
            "ajax" => false, //does this table support ajax?
        ]);
        add_action("admin_notices", array($this, "fblikebox_notices"));

    }

    /**
     * Retrieve customers data from the database
     *
     * @param int $per_page
     * @param int $page_number
     *
     * @return mixed
     */
    public static function get_fb_likeboxes($per_page = 20, $page_number = 1) {

        global $wpdb;

        $sql = "SELECT * FROM {$wpdb->prefix}ays_fbl";

        if (!empty($_REQUEST["orderby"])) {
            $sql .= " ORDER BY " . esc_sql($_REQUEST["orderby"]);
            $sql .= !empty($_REQUEST["order"]) ? " " . esc_sql($_REQUEST["order"]) : " DESC";
        }

        $sql .= " LIMIT $per_page";
        $sql .= " OFFSET " . ($page_number - 1) * $per_page;

        $result = $wpdb->get_results($sql, "ARRAY_A");

        return $result;
    }

    public function get_fb_likebox_by_id($id) {
        global $wpdb;

        $sql = "SELECT * FROM {$wpdb->prefix}ays_fbl WHERE id=" . absint(intval($id));

        $result = $wpdb->get_row($sql, "ARRAY_A");

        return $result;
    }

    public function ays_fb_publish_unpublish( $id, $action ) {
        global $wpdb;
        $pb_table = $wpdb->prefix."ays_fbl";
       
        if ($id == null) {
            return false;
        }
        if ($action == 'unpublish') {
            $onoffswitch = 'Off';
            $message = 'unpublished';
        }else{
            $onoffswitch = 'On';
            $message = 'published';
        }

        $pb_result = $wpdb->update(
                $pb_table,
                array(
                    "onoffswitch" => $onoffswitch
                ),
                array( "id" => $id ),
                array( "%s" ),
                array( "%d" )
            );

        $url = esc_url_raw( remove_query_arg(["action", "popupbox", "_wpnonce"]) ) . "&status=" . $message . "&type=success";
        wp_redirect( $url );
    }

    public function add_or_edit_fb_likebox($data) {
        
        global $wpdb;
        $fbl_table = $wpdb->prefix . "ays_fbl";

        if (isset($data["fblb_action"]) && wp_verify_nonce($data["fblb_action"], 'fblb_action')) {
            $id = ($data["id"] != NULL) ? absint(intval($data["id"])) : null;
            $likebox_url = sanitize_text_field($data['ays-facebook-popup-likebox']["ays_fb_url"]);
            $content = isset($data['ays-facebook-popup-likebox']["ays_fb_content"]) ? sanitize_text_field(implode("***", $data['ays-facebook-popup-likebox']["ays_fb_content"])) : '';
            $header_options = isset($data['ays-facebook-popup-likebox']["ays_fb_header_options"]) ? sanitize_text_field(implode("***", $data['ays-facebook-popup-likebox']["ays_fb_header_options"])) : '';
            $width = absint(intval($data['ays-facebook-popup-likebox']["ays_fb_width"]));
            $height = absint(intval($data['ays-facebook-popup-likebox']["ays_fb_height"]));
            $autoclose = absint(intval($data['ays-facebook-popup-likebox']["ays_fb_autoclose"]));
            $cookie = absint(intval($data['ays-facebook-popup-likebox']["ays_fb_cookie"]));
            $title = wp_unslash(sanitize_text_field($data['ays-facebook-popup-likebox']["ays_fb_likebox_title"]));
            $description = wp_unslash(sanitize_text_field($data['ays-facebook-popup-likebox']["ays_fb_likebox_description"]));
            $bgcolor = wp_unslash(sanitize_text_field($data['ays-facebook-popup-likebox']["ays_fb_bgcolor"]));
            $textcolor = wp_unslash(sanitize_text_field($data['ays-facebook-popup-likebox']["ays_fb_textcolor"]));
            $bordersize = wp_unslash(sanitize_text_field($data['ays-facebook-popup-likebox']["ays_fb_bordersize"]));
            $bordercolor = wp_unslash(sanitize_text_field($data['ays-facebook-popup-likebox']["ays_fb_bordercolor"]));
            $border_radius = wp_unslash(sanitize_text_field($data['ays-facebook-popup-likebox']["ays_fb_border_radius"]));
            $custom_css = $data['ays-facebook-popup-likebox']["ays_fb_custom_css"];
            $show_all = wp_unslash(sanitize_text_field($data['ays-facebook-popup-likebox']["ays_fb_show_all"]));

            $switch = (isset($data['ays-facebook-popup-likebox']["onoffswitch"]) && $data['ays-facebook-popup-likebox']["onoffswitch"] != "") ? 'On' : 'Off';

            $popup_likebox_title = (isset($data['ays-facebook-popup-likebox']["show_popup_likebox_title"]) && $data['ays-facebook-popup-likebox']["show_popup_likebox_title"] != '') ? 'On' : 'Off';
            $popup_likebox_description = (isset($data['ays-facebook-popup-likebox']["show_popup_likebox_description"]) && $data['ays-facebook-popup-likebox']["show_popup_likebox_description"] != '') ? 'On' : 'Off';
            $popup_likebox_guest = (isset($data['ays-facebook-popup-likebox']["popup_likebox_guest"]) && $data['ays-facebook-popup-likebox']["popup_likebox_guest"] != '') ? 'On' : 'Off';
            $popup_likebox_logged_users = (isset($data['ays-facebook-popup-likebox']["popup_likebox_logged_users"]) && $data['ays-facebook-popup-likebox']["popup_likebox_logged_users"] != '') ? 'On' : 'Off';
            $click_to_action = wp_unslash(sanitize_text_field($data['ays-facebook-popup-likebox']["ays_fb_click_to_action"]));
            $animation_in = wp_unslash(sanitize_text_field($data['ays-facebook-popup-likebox']["ays_fb_animation_in"]));
            $animation_out = wp_unslash(sanitize_text_field($data['ays-facebook-popup-likebox']["ays_fb_animation_out"]));
            $delay = wp_unslash(sanitize_text_field($data['ays-facebook-popup-likebox']["ays_fb_delay"]));
            $scroll_top = wp_unslash(sanitize_text_field($data['ays-facebook-popup-likebox']["ays_fb_scroll_top"]));
            $ays_fb_language = wp_unslash(sanitize_text_field($data["ays_fb_language"]["lang"]));

            // Custom class for quiz container
            $custom_class = (isset($data['ays-facebook-popup-likebox']["custom-class"]) && $data['ays-facebook-popup-likebox']["custom-class"] != "") ? $data['ays-facebook-popup-likebox']["custom-class"] : '';

            // PopupBox max-width for mobile option
            $mobile_max_width = (isset($data['ays-facebook-popup-likebox']['mobile_max_width']) && $data['ays-facebook-popup-likebox']['mobile_max_width'] != "") ? $data['ays-facebook-popup-likebox']['mobile_max_width'] : '';

            //Hide likebox on mobile
            $fb_mobile = (isset($data['ays_fb_mobile']) && $data['ays_fb_mobile'] == 'on') ? 'on' : 'off';

            //Show LikeBox only once
            $show_only_once = (isset($data['ays_fb_show_only_once']) && $data['ays_fb_show_only_once'] == 'on') ? 'on' : 'off';

            //Overlay
            $onoffoverlay = (isset($data['ays_fb_onoffoverlay']) && $data["ays_fb_onoffoverlay"] != "") ? $data["ays_fb_onoffoverlay"] : 'off';

            //Close popup likebox by esc
            $close_fbl_esc = (isset($data['close_fbl_esc']) && $data['close_fbl_esc'] == 'on') ? 'on' : 'off';

             //font-family
            $fbl_font_family = (isset($data['ays_fbl_font_family']) && $data['ays_fbl_font_family'] != '') ? $data['ays_fbl_font_family'] : 'initial';

            // Background Image
            $bg_image  = (isset($data['ays_fb_bg_image']) && $data['ays_fb_bg_image'] != '') ? wp_http_validate_url($data['ays_fb_bg_image']) : '';

            //title and description font-size
            $title_fontsize = (isset($data['ays-facebook-popup-likebox']["ays_fb_fontize_title"]) && $data['ays-facebook-popup-likebox']["ays_fb_fontize_title"] != "" && $data['ays-facebook-popup-likebox']["ays_fb_fontize_title"] != "0") ? absint(intval($data['ays-facebook-popup-likebox']["ays_fb_fontize_title"])) : '32';
           
            $description_fontsize = (isset($data['ays-facebook-popup-likebox']["ays_fb_fontize_description"]) && $data['ays-facebook-popup-likebox']["ays_fb_fontize_description"] != "" && $data['ays-facebook-popup-likebox']["ays_fb_fontize_description"] != "0") ? absint(intval($data['ays-facebook-popup-likebox']["ays_fb_fontize_description"])) : '13';

            if ($show_all == 'yes') {
                $view_place = '';
            } else {
                $view_place = isset($data['ays-facebook-popup-likebox']["ays_fb_header_options"]) ? sanitize_text_field(implode("***", $data['ays-facebook-popup-likebox']["ays_fb_view_place"])) : '';
            }

            $options = array(
                'popup_likebox_title'        => $popup_likebox_title,
                'popup_likebox_description'  => $popup_likebox_description,
                'popup_likebox_guest'        => $popup_likebox_guest,
                'popup_likebox_logged_users' => $popup_likebox_logged_users,
                'mobile_max_width'           => $mobile_max_width,
                'fb_mobile'                  => $fb_mobile,
                'show_only_once'             => $show_only_once,
                'close_fbl_esc'              => $close_fbl_esc,
                'onoffoverlay'               => $onoffoverlay,
                'bg_image'                   => $bg_image,
                'title_fontsize'             => $title_fontsize,
                'description_fontsize'       => $description_fontsize,
                'fbl_font_family'            => $fbl_font_family
            );


            $ays_change_type = (isset($data['ays_change_type'])) ? $data['ays_change_type'] : '';
            if ($id == null) {
                $fbl_result = $wpdb->insert(
                    $fbl_table,
                    array(
                        "title"           => $title,
                        "description"     => $description,
                        "content"         => $content,
                        "header_options"  => $header_options,
                        "autoclose"       => $autoclose,
                        "cookie"          => $cookie,
                        "url"             => $likebox_url,
                        "width"           => $width,
                        "height"          => $height,
                        "bgcolor"         => $bgcolor,
                        "textcolor"       => $textcolor,
                        "bordersize"      => $bordersize,
                        "bordercolor"     => $bordercolor,
                        "border_radius"   => $border_radius,
                        "custom_css"      => $custom_css,
                        "onoffswitch"     => $switch,
                        "show_all"        => $show_all,
                        "click_to_action" => $click_to_action,
                        "view_place"      => $view_place,
                        "delay"           => $delay,
                        "scroll_top"      => $scroll_top,
                        "animate_in"      => $animation_in,
                        "animate_out"     => $animation_out,
                        "lang"            => $ays_fb_language,
                        "custom_class"    => $custom_class,
                        "options"         => json_encode($options),
                    ),
                    array("%s", "%s", "%s", "%s", "%d", "%d", "%s", "%d", "%d", "%s", "%s", "%d", "%s", "%d", "%s", "%s", "%s", "%s", "%s", "%d", "%d", "%s", "%s","%s","%s","%s")
                );
                $message = "created";
            } else {
                $fbl_result = $wpdb->update(
                    $fbl_table,
                    array(
                        "title"           => $title,
                        "description"     => $description,
                        "content"         => $content,
                        "header_options"  => $header_options,
                        "autoclose"       => $autoclose,
                        "cookie"          => $cookie,
                        "url"             => $likebox_url,
                        "width"           => $width,
                        "height"          => $height,
                        "bgcolor"         => $bgcolor,
                        "textcolor"       => $textcolor,
                        "bordersize"      => $bordersize,
                        "bordercolor"     => $bordercolor,
                        "border_radius"   => $border_radius,
                        "custom_css"      => $custom_css,
                        "onoffswitch"     => $switch,
                        "show_all"        => $show_all,
                        "click_to_action" => $click_to_action,
                        "view_place"      => $view_place,
                        "delay"           => $delay,
                        "scroll_top"      => $scroll_top,
                        "animate_in"      => $animation_in,
                        "animate_out"     => $animation_out,
                        "lang"            => $ays_fb_language,
                        "custom_class"    => $custom_class,
                        "options"         => json_encode($options),
                    ),
                    array("id" => $id),
                    array("%s", "%s", "%s", "%s", "%d", "%d", "%s", "%d", "%d", "%s", "%s", "%d", "%s", "%d", "%s", "%s", "%s", "%s", "%s", "%d", "%d", "%s", "%s", "%s","%s", "%s"),
                    array("%d")
                );
                $message = "updated";
            }

            $ays_fb_tab = isset($data['ays_fb_tab']) ? $data['ays_fb_tab'] : 'tab1';
            if( $fbl_result >= 0 ){
                if($ays_change_type != ''){
                    if($id == null){
                        $url = esc_url_raw( add_query_arg( array(
                            "action"    => "edit",
                            "fblikebox"      => $wpdb->insert_id,
                            "ays_fb_tab"  => $ays_fb_tab,
                            "status"    => $message
                        ) ) );
                    }else{
                        $url = esc_url_raw( add_query_arg( array(
                            "ays_fb_tab"  => $ays_fb_tab,
                            "status"    => $message
                        ) ) );
                    }
                    wp_redirect( $url);
                }else{
                    $url = esc_url_raw( remove_query_arg(["action"]) ) . "&status=" . $message . "&type=success";
                    wp_redirect( $url );
                }
            }
        }
    }

    /**
     * Delete a customer record.
     *
     * @param int $id customer ID
     */
    public static function delete_fb_likeboxes($id) {
        global $wpdb;
        $wpdb->delete(
            "{$wpdb->prefix}ays_fbl",
            ["id" => $id],
            ["%d"]
        );
    }

    /**
     * Returns the count of records in the database.
     *
     * @return null|string
     */
    public static function record_count() {
        global $wpdb;

        $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}ays_fbl";

        return $wpdb->get_var($sql);
    }

    /** Text displayed when no customer data is available */
    public function no_items() {
        _e("There are no likeboxes yet.", $this->plugin_name);
    }

    /**
     * Render a column when no column specific method exist.
     *
     * @param array $item
     * @param string $column_name
     *
     * @return mixed
     */
    public function column_default($item, $column_name) {
        switch ($column_name) {
        case "title":
        case "onoffswitch":
            return $item[$column_name];
            break;
        case "id":
            return $item[$column_name];
            break;
        default:
            return print_r($item, true); //Show the whole array for troubleshooting purposes
        }
    }

    /**
     * Render the bulk edit checkbox
     *
     * @param array $item
     *
     * @return string
     */
    function column_cb($item) {
        return sprintf(
            "<input type='checkbox' name='bulk-delete[]' value='%s' />", $item["id"]
        );
    }

    /**
     * Method for name column
     *
     * @param array $item an array of DB data
     *
     * @return string
     */
    function column_title($item) {
        $delete_nonce = wp_create_nonce($this->plugin_name . "-delete-fblikebox");
        $unpublish_nonce = wp_create_nonce( $this->plugin_name . "-unpublish-fblikebox" );
        $publish_nonce = wp_create_nonce( $this->plugin_name . "-publish-fblikebox" );

        if (isset($item['onoffswitch']) && $item['onoffswitch'] == 'On') {
            $publish_button = 'unpublish';
            $publish_button_val = sprintf( '<a href="?page=%s&action=%s&fblikebox=%d&_wpnonce=%s">'. __('Unpublish', $this->plugin_name) .'</a>', esc_attr( $_REQUEST['page'] ), 'unpublish', absint( $item['id'] ), $unpublish_nonce );
        }else{
            $publish_button = 'publish';
            $publish_button_val = sprintf( '<a href="?page=%s&action=%s&fblikebox=%d&_wpnonce=%s">'. __('Publish', $this->plugin_name) .'</a>', esc_attr( $_REQUEST['page'] ), 'publish', absint( $item['id'] ), $publish_nonce );
        }
        
        $title = sprintf("<a href='?page=%s&action=%s&fblikebox=%d'>" . $item["title"] . "</a>", esc_attr($_REQUEST["page"]), "edit", absint($item["id"]));

        $actions = [
            "edit" => sprintf("<a href='?page=%s&action=%s&fblikebox=%d'>" . __('Edit') . "</a>", esc_attr($_REQUEST["page"]), "edit", absint($item["id"])),

            $publish_button => $publish_button_val,

            "delete" => sprintf("<a href='?page=%s&action=%s&fblikebox=%s&_wpnonce=%s'>" . __('Delete') . "</a>", esc_attr($_REQUEST["page"]), "delete", absint($item["id"]), $delete_nonce),
        ];

        return $title . $this->row_actions($actions);
    }

    function column_shortcode($item) {
        if ($item['show_all'] == 'no') {
            return sprintf("<input type='text' onClick='this.setSelectionRange(0, this.value.length)' readonly style='width:250px;' value='[ays_fb_popup_likebox id=%s]' />", $item["id"]);
        } else {return;}

    }

    /**
     *  Associative array of columns
     *
     * @return array
     */
    function get_columns() {
        $columns = [
            "cb" => "<input type='checkbox' />",
            "title" => __("Title", $this->plugin_name),
            "onoffswitch" => __("Enabled/Disabled", $this->plugin_name),
            "id" => __("ID", $this->plugin_name),
        ];

        return $columns;
    }

    /**
     * Columns to make sortable.
     *
     * @return array
     */
    public function get_sortable_columns() {
        $sortable_columns = array(
            "title" => array("title", true),
            "id" => array("id", true),
        );

        return $sortable_columns;
    }

    /**
     * Returns an associative array containing the bulk action
     *
     * @return array
     */
    public function get_bulk_actions() {
        $actions = [
            "bulk-delete" => "Delete",
        ];

        return $actions;
    }

    /**
     * Handles data query and filter, sorting, and pagination.
     */
    public function prepare_items() {

        $this->_column_headers = $this->get_column_info();

        /** Process bulk action */
        $this->process_bulk_action();

        $per_page = $this->get_items_per_page("fblikeboxes_per_page", 20);
        $current_page = $this->get_pagenum();
        $total_items = self::record_count();

        $this->set_pagination_args([
            "total_items" => $total_items, //WE have to calculate the total number of items
            "per_page" => $per_page, //WE have to determine how many items to show on a page
        ]);

        $this->items = self::get_fb_likeboxes($per_page, $current_page);
    }

    public function process_bulk_action() {
        //Detect when a bulk action is being triggered...
        $message = "deleted";
        if ("delete" === $this->current_action()) {

            // In our file that handles the request, verify the nonce.
            $nonce = esc_attr($_REQUEST["_wpnonce"]);

            if (!wp_verify_nonce($nonce, $this->plugin_name . "-delete-fblikebox")) {
                die("Go get a life script kiddies");
            } else {
                self::delete_fb_likeboxes(absint($_GET["fblikebox"]));

                // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
                // add_query_arg() return the current url

                $url = esc_url_raw(remove_query_arg(["action", "fblikebox", "_wpnonce"])) . "&status=" . $message . "&type=success";
                wp_redirect($url);
                exit();
            }

        }

        // If the delete bulk action is triggered
        if ((isset($_POST["action"]) && $_POST["action"] == "bulk-delete")
            || (isset($_POST["action2"]) && $_POST["action2"] == "bulk-delete")
        ) {

            $delete_ids = esc_sql($_POST["bulk-delete"]);

            // loop over the array of record IDs and delete them
            foreach ($delete_ids as $id) {
                self::delete_fb_likeboxes($id);

            }

            // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
            // add_query_arg() return the current url

            $url = esc_url_raw(remove_query_arg(["action", "fblikebox", "_wpnonce"])) . "&status=" . $message . "&type=success";
            wp_redirect($url);
            exit();
        }
    }

    public function fblikebox_notices() {
        $status = (isset($_REQUEST["status"])) ? sanitize_text_field($_REQUEST["status"]) : "";
        $type = (isset($_REQUEST["type"])) ? sanitize_text_field($_REQUEST["type"]) : "";

        if (empty($status)) {
            return;
        }

        if ("created" == $status) {
            $updated_message = esc_html(__("Facebook Likebox created.", $this->plugin_name));
        } elseif ("updated" == $status) {
            $updated_message = esc_html(__("Facebook Likebox saved.", $this->plugin_name));
        } elseif ( 'published' == $status ) {
            $updated_message = esc_html( __( 'Facebook Likebox published.', $this->plugin_name ) );
        } elseif ( 'unpublished' == $status ) {
            $updated_message = esc_html( __( 'Facebook Likebox unpublished.', $this->plugin_name ) );
        } elseif ("deleted" == $status) {
            $updated_message = esc_html(__("Facebook Likebox deleted.", $this->plugin_name));
        } elseif ("error" == $status) {
            $updated_message = __("You're not allowed to add likebox for more likeboxes please checkout to ", $this->plugin_name) . "<a href='http://ays-pro.com/index.php/wordpress/facebook-popup-likebox' target='_blank'>PRO " . __("version", $this->plugin_name) . "</a>.";
        }

        if (empty($updated_message)) {
            return;
        }

        ?>
        <div class="notice notice-<?php echo $type; ?> is-dismissible">
            <p> <?php echo $updated_message; ?> </p>
        </div>
        <?php
}
}
