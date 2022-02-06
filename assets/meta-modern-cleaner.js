jQuery(document).ready(function() {

    jQuery('#get_metas').click( function() {
        var data = {
            action: 'get_metas',
            selected_post_types: jQuery('select#post_types').val()
        };
        
        jQuery.post( ajaxurl, data, function( response ){
            jQuery("#u_metas").empty();
            jQuery("#u_metas").append(response);
            jQuery('#metas_chosen').css('visibility', 'visible');
            jQuery('#post_types').attr('disabled', '');
            jQuery('#get_metas').css('display', 'none');
            jQuery('.meta-modern-cleaner-container-column.post_types').append('<button id="start_again" type="button">New try</button>');
            jQuery('button#start_again').click( function() {
                location.reload();
            });
        } );
    } );

    jQuery('#metas_chosen').click( function() {
        var data = {
            action: 'before_cleaning',
            selected_post_types: jQuery('select#post_types').val(),
            selected_metas: jQuery('select#u_metas').val()
        };

        
        jQuery.post( ajaxurl, data, function( response ){
            jQuery("#confirmation_area").empty();
            jQuery('#confirmation_area').append(response);
            jQuery('#confirmation_area').addClass('meta-modern-cleaner-container-column confirmation');
            jQuery('#no_return').click( function() {
                location.reload();
            } );
            jQuery('#yes_confirm').click( function() {
                var data = {
                    action: 'meta_delete_confirmed',
                    selected_post_types: jQuery('select#post_types').val(),
                    selected_metas: jQuery('select#u_metas').val(),
                };
                
                jQuery('#confirmation_area').empty().append('<img src="/wp-content/plugins/meta-modern-cleaner/assets/loader.svg" />').css('align-items', 'center');

                jQuery.post( ajaxurl, data, function( response ){
                    jQuery("#confirmation_area").empty().append(response).css('align-items', 'flex-start');
                } );
            } );
            
        } );
    } );


});