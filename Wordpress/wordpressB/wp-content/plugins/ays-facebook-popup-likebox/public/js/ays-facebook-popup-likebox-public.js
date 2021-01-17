    (function($) {
        'use strict';
        document.addEventListener('DOMContentLoaded', function () {
            (function(d, s, id) {
                let ays_fb_language,js, fjs = d.getElementsByTagName(s)[0];
                if (ays_fb_language == null) {
                    ays_fb_language = 'en_US';
                }
                if (d.getElementById(id)) return;
                js = d.createElement(s);
                js.id = id;
                js.src = 'https://connect.facebook.net/'+ ays_fb_language.lang +'/sdk.js#xfbml=1&version=v3.0&appId=1204514392893219&autoLogAppEvents=1';
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        }, false)
    })(jQuery);