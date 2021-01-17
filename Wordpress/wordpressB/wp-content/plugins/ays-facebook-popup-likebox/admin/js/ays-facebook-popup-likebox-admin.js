(function( $ ) {
	'use strict';
    $(document).ready(function (){
        $(document).find('.nav-tab-wrapper a.nav-tab').on('click', function(e){
            let elemenetID = $(this).attr('href');
            let active_tab = $(this).attr('data-tab');
            $(document).find('.nav-tab-wrapper a.nav-tab').each(function(){
            if( $(this).hasClass('nav-tab-active') ){
                $(this).removeClass('nav-tab-active');
            }
            });
            $(this).addClass('nav-tab-active');
                $(document).find('.ays-fpl-tab-content').each(function(){
                if( $(this).hasClass('ays-fpl-tab-content-active') )
                    $(this).removeClass('ays-fpl-tab-content-active');
            });
            $(document).find("[name='ays_fb_tab']").val(active_tab);
            $('.ays-fpl-tab-content' + elemenetID).addClass('ays-fpl-tab-content-active');
            e.preventDefault();
        });
         
         $(document).find('.ays_fpl_color_input').wpColorPicker();  
         $(document).find('.ays-fpl-tab-content select').select2();
         var ays_fb_view_place = $(document).find('#ays-facebook-popup-likebox-ays_fb_view_place').select2({
             placeholder: 'Select page',
             dropdownAdapter: $.fn.select2.amd.require('select2/selectAllAdapter'),
             multiple: true,
             matcher: searchForPage
         });
         
         $(document).find('.ays_view_place_clear').on('click', function(){
              ays_fb_view_place.val(null).trigger('change');
         });

         $(document).on('click', '.ays-remove-bg-img', function () {
            $(document).find('img#ays-fb-bg-img').attr('src', '');
            $(document).find('input#ays-fb-bg-image').val('');
            $(document).find('.ays-fb-bg-image-container').parent().fadeOut();
            $(document).find('a.ays-fb-add-bg-image').text('Add Image');
            $(document).find('.box-apm').css('background-image', 'unset');
            $(document).find('.ays_bg_image_box').css('background-image', 'unset');
         });

         $(document).on('click', 'a.ays-fb-add-bg-image', function (e) {
            openMediaUploaderBg(e, $(this));
         });
        
        $('[data-toggle="tooltip"]').tooltip();


// Code Mirror
             
              setTimeout(function(){
            if($(document).find('#ays_fbl_custom_css').length > 0){
                let CodeEditor = null;
                if(wp.codeEditor){
                    CodeEditor = wp.codeEditor.initialize($(document).find('#ays_fbl_custom_css'), cm_settings);
                }
                if(CodeEditor !== null){
                    CodeEditor.codemirror.on('change', function(e, ev){
                        $(CodeEditor.codemirror.display.input.div).find('.CodeMirror-linenumber').remove();
                        $(document).find('#ays_fbl_custom_css').val(CodeEditor.codemirror.display.input.div.innerText);
                            
                    });
                }
            

            }
        }, 500);
       
          $(document).find('a[href="#tab2"]').on('click', function (e) {        
            setTimeout(function(){
                if($(document).find('#ays_fbl_custom_css').length > 0){
                    var ays_fbl_custom_css = $(document).find('#ays_fbl_custom_css').html();
                    if(wp.codeEditor){
                        $(document).find('#ays_fbl_custom_css').next('.CodeMirror').remove();
                        var CodeEditor = wp.codeEditor.initialize($(document).find('#ays_fbl_custom_css'), cm_settings);

                        CodeEditor.codemirror.on('change', function(e, ev){
                            $(CodeEditor.codemirror.display.input.div).find('.CodeMirror-linenumber').remove();
                            $(document).find('#ays_fbl_custom_css').val(CodeEditor.codemirror.display.input.div.innerText);
                        });
                        ays_fbl_custom_css = CodeEditor.codemirror.getValue();
                        $(document).find('#ays_fbl_custom_css').html(ays_fbl_custom_css);
                    }
                }
            }, 500);
           
        });
           
      
 
    });
    
    function searchForPage(params, data) {
        // If there are no search terms, return all of the data
        if ($.trim(params.term) === '') {
          return data;
        }

        // Do not display the item if there is no 'text' property
        if (typeof data.text === 'undefined') {
          return null;
        }
        var searchText = data.text.toLowerCase();
        // `params.term` should be the term that is used for searching
        // `data.text` is the text that is displayed for the data object
        if (searchText.indexOf(params.term) > -1) {
          var modifiedData = $.extend({}, data, true);
          modifiedData.text += ' (matched)';

          // You can return modified objects from here
          // This includes matching the `children` how you want in nested data sets
          return modifiedData;
        }

        // Return `null` if the term should not be displayed
        return null;
    }

    function openMediaUploaderBg(e, element) {
        e.preventDefault();
        let aysUploader = wp.media({
            title: 'Upload',
            button: {
                text: 'Upload'
            },
            library: {
                type: 'image'
            },
            multiple: false
        }).on('select', function () {
            let attachment = aysUploader.state().get('selection').first().toJSON();
            element.text('Edit Image');
            $('.ays-fb-bg-image-container').parent().fadeIn();
            $('img#ays-fb-bg-img').attr('src', attachment.url);
            $('input#ays-fb-bg-image').val(attachment.url);
            $('.box-apm').css('background-image', `url('${attachment.url}')`);
            $('.ays_bg_image_box').css({
                'background-image' : `url('${attachment.url} ')`,
                'background-repeat' : 'no-repeat',
                'background-size' : 'cover',
                'background-position' : 'center center'
            });
            ////
        }).open();
        return false;
    }
})( jQuery );
