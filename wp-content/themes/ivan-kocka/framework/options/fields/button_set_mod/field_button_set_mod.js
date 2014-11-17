/*
 Field Button Set (button_set_mod)
 */

/*global jQuery, document, redux*/

(function( $ ) {
    "use strict";

    redux.field_objects = redux.field_objects || {};
    redux.field_objects.button_set_mod = redux.field_objects.button_set_mod || {};

    $( document ).ready(
        function() {
            //redux.field_objects.button_set_mod.init();
            if ( $.fn.button.noConflict !== undefined ) {
                var btn = $.fn.button.noConflict();
                $.fn.btn = btn;
            }
        }
    );

    redux.field_objects.button_set_mod.init = function( selector ) {
        if ( !selector ) {
            selector = $( document ).find( '.redux-container-button_set_mod' );
        }

        $( selector ).each(
            function() {
                var el = $( this );
                var parent = el;
                if ( !el.hasClass( 'redux-field-container' ) ) {
                    parent = el.parents( '.redux-field-container:first' );
                }

                if ( parent.hasClass( 'redux-field-init' ) ) {
                    parent.removeClass( 'redux-field-init' );
                } else {
                    return;
                }

                el.find( '.buttonset-mod' ).each(
                    function() {
                        if ( $( this ).is( ':checkbox' ) ) {
                            $( this ).find( '.buttonset-item' ).button();
                        }

                        //console.log("Running Modified!");

                        $( this ).buttonset();
                    }
                );
            }
        );

    };
})( jQuery );