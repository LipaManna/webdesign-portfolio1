(function( $ ) {
    $.fn.select2.amd.define('select2/selectAllAdapter', [
        'select2/utils',
        'select2/dropdown',
        'select2/dropdown/attachBody'
    ], function(Utils, Dropdown, AttachBody) {
        function SelectAll() {}

        SelectAll.prototype.render = function(decorated) {
            let $rendered = decorated.call(this);
            let self = this;

            let $selectAll = $(
                '<ul><li class="ays_select_everything">Select All</li></ul>'
            );

            let checkOptionsCount = function() {
                let count = $('.select2-results__option').length;
                $selectAll.children('li.ays_select_everything').text('All pages');
            };


            let $container = $('.select2-container');
            $container.bind('keyup click', checkOptionsCount);

            let $dropdown = $rendered.find('.select2-dropdown');


            $dropdown.prepend($selectAll);

            $selectAll.on('click', function(e) {
                let $results = $rendered.find('.select2-results__option[aria-selected=false]');


                // Get all results that aren't selected
                $results.each(function() {
                    let $result = $(this);
                    // Get the data object for it
                    let data = $result.data('data');
                    // Trigger the select event
                    self.trigger('select', {
                        data: data
                    });
                });

                self.trigger('close');
            });

            return $rendered;
        };

        return Utils.Decorate(
            Utils.Decorate(
                Dropdown,
                AttachBody
            ),
            SelectAll
        );
    });
})( jQuery );