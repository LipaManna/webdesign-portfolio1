(function ($) {
    'use strict';

    $(document).on('click', '[data-slug="ays-facebook-popup-likebox"] .deactivate a', function () {
        swal({
            html:"<h2>Do you want to upgrade to Pro version or permanently delete the plugin?</h2><ul><li>Upgrade: Your data will be saved for upgrade.</li><li>Uninstall: Your data will be deleted completely.</li></ul>",
            type: 'question',
            showCancelButton: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Upgrade',
            cancelButtonText: 'Deactivate'
        }).then((result) => {
            var upgrade_plugin = false;
            if (result.value) upgrade_plugin = true;
            var data = {action: 'deactivate_plugin_option_fb', upgrade_plugin: upgrade_plugin};
            $.ajax({
                url: fb_likebox_ajax.ajax_url,
                method: 'post',
                dataType: 'json',
                data: data,
                success:function () {
                    window.location = $(document).find('[data-slug="ays-facebook-popup-likebox"]').find('.deactivate').find('a').attr('href');
                }
            });
        });
        return false;
    });
})(jQuery);