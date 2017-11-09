/* global jQuery */
(function(api, $) {
    "use strict";
    let cstSorterControl = {
        update: function (element,ui,$collection) {
            console.log( ui.item[0].innerText + ' changed' );
            let list = element.find('.cst-item');
            let inputValues = list.map(function() {
                return $(this).data('slug');
            }).toArray();
            $collection.val(inputValues);
            element.trigger( 'change' );
        }
    }
    api.controlConstructor.cst_sf_sorter_control = api.Control.extend({
        ready: function() {
            let control = this;
            let list, itemMoved, $item;
            let element = $("#" + control.id);
            let $collection = $("#" + control.id + '-collection');
            let collection = control.id + '-collection';
            api.Control.prototype.ready.call(control);
            element.sortable({
                change: function (event, ui) {
                    console.log(ui.item[0] + ' changed.');
                    itemMoved = setTimeout( $.proxy( function(){
                        $(this).find('.highlight').removeClass('highlight');
                        itemMoved = 0;
                    }, this ), 3000 );
                    ui.item.addClass('highlight');
                },
                update: function (event, ui) {
                    cstSorterControl.update(element,ui,$collection);
                }
            });
            element.on( 'change', function(e) {
                api(collection, function (value) {
                    let updateMe = function (newval) {
                        value.set(newval);
                    };
                    updateMe($collection.val());
                });
            });
        },
    });

})(wp.customize, jQuery);