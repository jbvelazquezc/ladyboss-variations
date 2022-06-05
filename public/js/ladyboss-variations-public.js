(function( $ ) {
	'use strict';

	 $(function() {

		var selects = new Array();
		var resetVar = 0;

		// Reset selects
		$('form.variations_form select').prop('selectedIndex',0);
	
		// Custom Alert messages when no option is selected
		$('.single_add_to_cart_button').on('click',function(e){

			var selects_val_b = new Array();

			var a = " ";

			var $thisbutton = $(this),
                $form = $thisbutton.closest('form.cart');

			if ( $thisbutton.hasClass('disabled') ) {
			
				e.preventDefault();

				if ( $thisbutton.is('.wc-variation-selection-needed') ) {
				
					$form.find('select').each(
						function(index){  
						
						if ( $(this).val() === '' ) {
							var label_text = $(this).closest('tr').find('.label').text();
							selects_val_b.push( label_text );
						}
					});

					if ( selects_val_b.length == 1 ) {
						a = ' a ';
					}
				
					alert ( "Please select"+a+selects_val_b.join(' & ')+" before adding this product to your cart.");
					selects_val_b = [];
					a = ' ';
					return false;
				
				} else if ( $(this).find('.single_add_to_cart_button').is('.wc-variation-is-unavailable') ) {
					alert( "Sorry, this product combination is temporarily out of stock. Please choose a different combination." );
					return false;
				} 
			}
		});

		// Check how many selects we have and save ids in array
		function checkSelects ( $formA ) {
			$formA.find('select').each(
				function(index){  
				var select_id = $(this).attr('id');
				selects.push( select_id );
			});
			resetVar = selects.length;
		}
		
		// Buttons
		$('.variation-items-li').on('click', function() {

			var $thisbutton = $(this),
				$form = $thisbutton.closest('form.cart');

			checkSelects( $form );

			// When selects have finished to change, we run the function to enable/disable buttons
			$.when( $form.change() ).then(function() {

				// Only run when there is more than 1 select
				if ( selects.length > 1 ) {
					
					// Loop through selects
					for (var i = 0; i < selects.length; ++i) {

						var values = [];
						$(this).find('#'+selects[i]+' option').each( function () { values.push ( $(this).val() ); });

						var liElements = 'ul.'+selects[i];
						
						// Reset the buttos by removing button-disabled class from all
						$(this).find(liElements+' li').removeClass('button-disabled');
						
						// Add class depending in comparation
						$(this).find(liElements+' li').each(function() {
							var item = $(this);

							if( ! jQuery.inArray( item.attr('data-value'), values ) !== -1) {	
								item.addClass('button-disabled');
							}

						});		
					}
				}
				selects = [];
       		});			

			$form.find('.lb-clear-button').css('visibility', 'visible');

			var att = $(this).attr('data-value'),
				pa_select = $(this).attr('data-slug');

			var att_to_show = $(this).children('span').text();

			$(this).closest('div.lb-available-attributes').find('span.show_att').html('<b>: </b>'+att_to_show);
			
			$(this).closest('ul').find('li').removeClass('button-selected');

			$(this).addClass('button-selected');

			$(this).closest('form.variations_form').find('table.variations #'+pa_select).val(att).change();

		});

		// Custom Clear button
		$('.lb-clear-button').on('click', function() {

			var $thisbutton = $(this),
				$form = $thisbutton.closest('form.cart');

			$form.find('table.variations td.value a.reset_variations').click();

			$thisbutton.closest('div.single_variation_wrap').find('.variation-items-li').removeClass('button-selected');

			// Only run when there is more than 1 select
			if ( resetVar > 1 ) {
				$thisbutton.closest('div.single_variation_wrap').find('.variation-items-li').removeClass('button-disabled');
				resetVar = 0;
			}

			$form.find('div.single_variation_wrap span.show_att').html('');

			$thisbutton.css('visibility', 'hidden');

		});
	 
	 });

})( jQuery );