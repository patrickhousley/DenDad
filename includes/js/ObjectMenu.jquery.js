(function ($) {
	$.fn.ObjectMenu = function () {
		$.fn.ObjectMenu.create_object_menu = function(target) {
			'use strict';
			/**
			 * Function to hide all subsequent UL and LI elements.
			 * Visibility: Private
			 */
			function hide_children(target_ul) {
				$(target_ul).find('ul').each(function () { $(this).hide(); hide_children(this); });
			}

			/**
			 * Function to show all subsequent children on mouseover.
			 * Visibility: Private
			 */
			function show_children(target_li) {
				/** Make sure the target has not been disabled **/
				if (!$(target_li).hasClass('ui-state-disabled')) {
					$(target_li).children('ul').each(function () {
						/** Show the UL element **/
						$(this).show()
							/** Add the css to the UL element **/
							.css({
								'border': '1px solid #333',
								'font-weight': 'normal',
								'left': '-5px',
								'top': '18px',
								'position': 'relative',
								'width': '200px',
								'z-index': '30'
							})
							/** Add the classes to the UL element **/
							.addClass('ui-state-default ui-widget-header ui-helper-reset');

						/** Check for any disabled elements **/
						$(this).children('li').each(function () {
							if ($(this).hasClass('ui-state-disabled')) { $(this).hide(); } else { $(this).show(); }
						});
					});
				}
			}

			/** Wrap the element in a containment div **/
			$(target)
                            .wrap('<div class="object_menu" />')
                            .css({
                                'margin': '0px'
                            });

			/** Add the css to the wrapper **/
			var wrapper = $(target).parent();
			$(wrapper).addClass('ui-helper-reset')
				.css({
					'line-height': '20px',
					'padding': '0px 10px 0px 10px',
					'height': '20px',
					'top': '0',
					'z-index': '2'
				});

			/** Add the css to the object menu **/
			$(target).children('li').each(function () {
				/** Add the css and classes to the first level LI elements **/
				$(this).addClass('ui-state-default ui-helper-reset ui-corner-all')
					.css({
						'float': 'left',
						'line-height': '18px',
						'height': '18px',
						'padding': '0px 5px 0px 5px',
						'cursor': 'pointer',
						'width': '100px',
                                                'z-index': '3'
					})
					.width($(this).children('a').eq(0).width() + 'px')
					/** Add the standard mouseover event handler **/
					.bind('mouseover', function () {
						show_children(this);
						$(this).addClass('ui-state-active')
							.bind('mouseout', function () {
								hide_children(this);
								$(this).removeClass('ui-state-active')
									.unbind('mouseout');
							});
					});

				/** Hide all the child UL elements **/
				hide_children(this);

				/** Add the css and event handlers to all subsequent LI elements **/
				$(this).find('li').each(function () {
					hide_children(this);
					$(this).addClass('ui-state-default ui-helper-reset')
						.bind('mouseover', function () {
							show_children(this);
							$(this).addClass('ui-state-active')
								.bind('mouseout', function () {
									hide_children(this);
									$(this).removeClass('ui-state-active')
										.unbind('mouseout');
								});
						})
						.css({
							'line-height': '20px',
							'height': '20px',
							'padding': '0px 5px 0px 5px',
							'cursor': 'pointer'
						});
				});
			});
		};
		
		$.fn.ObjectMenu.disable_object_menu_items = function (target, items) {
			'use strict';
			if (items !== undefined) {
				var d = items.split(','),
					i = 0;
				for (i = 0; i < d.length; i += 1) {
					$(target).find('A[href="#' + d[i] + '"]').parent().addClass('ui-state-disabled');
				}
			}
		};
		
		$.fn.ObjectMenu.enable_object_menu_items = function (target, items) {
			'use strict';
			if (items !== undefined) {
				var d = items.split(','),
					i = 0;
				for (i = 0; i < d.length; i += 1) {
					$(target).find('A[href="#' + d[i] + '"]').parent().removeClass('ui-state-disabled');
				}
			}
		};			
		
		$.fn.ObjectMenu.disable_object_menu = function (target, items) {
			'use strict';
			if (items !== undefined) {
				var d = items.split(','),
					i = 0;
				for (i = 0; i < d.length; i += 1) {
					$(target).find('li').eq(d[i]).addClass('ui-state-disabled');
				}
			}
		};
		
		$.fn.ObjectMenu.enable_object_menu = function (target, objects) {
			'use strict';
			if (items !== undefined) {
				var d = items.split(','),
					i = 0;
				for (i = 0; i < d.length; i += 1) {
					$(target).find('li').eq(d[i]).removeClass('ui-state-disabled');
				}
			}
		};

		return this.each(function(func, options) {
			$this = $(this);
			if (!func || func == 'create') {
				$.fn.ObjectMenu.create_object_menu($this);
			} else if (func == 'disable_menus') {
				$.fn.ObjectMenu.disable_object_menu($this, options);
			} else if (func == 'enable_menus') {
				$.fn.ObjectMenu.enable_object_menu($this, options);
			} else if (func == 'disable_menu_items') {
				$.fn.ObjectMenu.disable_object_menu_items($this, options);
			} else if (func == 'enable_menu_items') {
				$.fn.ObjectMenu.enable_object_menu_items($this, options);
			}
		});
	};
})(jQuery);