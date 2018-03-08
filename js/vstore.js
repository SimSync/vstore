var e107 = e107 || {'settings': {}, 'behaviors': {}};

(function ($)
{
	'use strict';

	/**
	 * Zoom object.
	 */
	e107.ImageZoom = null;

	/**
	 * Namespace for vstore related settings.
	 */
	e107.settings.vstore = e107.settings.vstore || {};

	/**
	 * Default settings for Zoom.
	 */
	e107.settings.vstore.ImageZoom = e107.settings.vstore.ImageZoom || {
		url: false,
		on: 'mouseover',
		duration: 120,
		target: false,
		touch: true,
		magnify: 1,
		callback: function ()
		{
			// TODO colorbox support?
		},
		onZoomIn: function ()
		{
		},
		onZoomOut: function ()
		{
		}
	};

	/**
	 * @type {{attach: e107.behaviors.vstoreImageZoom.attach}}
	 */
	e107.behaviors.vstoreImageZoom = {
		attach: function (context, settings)
		{
			$(context).find('.vstore-zoom').once('vstore-image-zoom').each(function ()
			{
				var $this = $(this);

				if(typeof $.fn.zoom !== 'undefined')
				{
					e107.ImageZoom = $this;
					e107.settings.vstore.ImageZoom.url = $this.find('img:first').attr('src');
					e107.ImageZoom.zoom(e107.settings.vstore.ImageZoom);
				}
			});
		}
	};

	/**
	 * @type {{attach: e107.behaviors.vstoreThumbnail.attach}}
	 */
	e107.behaviors.vstoreThumbnail = {
		attach: function (context, settings)
		{
			$(context).find('.thumbnails a').once('vstore-thumbnail').each(function ()
			{
				$(this).click(function ()
				{
					var $this = $(this);

					var newSrc = $this.data('standard');
					var newSrcSet = $this.attr('href');

					var $images = $('.vstore-zoom img');
					var $links = $('.vstore-zoom a');

					$images.attr('src', newSrc);
					$images.attr('srcset', newSrcSet);

					$links.attr('href', newSrcSet);
					$links.attr('data-standard', newSrc);

					// Change URL in Zoom settings.
					e107.settings.vstore.ImageZoom.url = newSrcSet;
					// Destroy Zoom object.
					e107.ImageZoom.trigger('zoom.destroy');
					// Re-init Zoom with new settings.
					e107.ImageZoom.zoom(e107.settings.vstore.ImageZoom);

					return false;
				});
			});
		}
	};

	/**
	 * @type {{attach: e107.behaviors.vstoreCartQty.attach}}
	 */
	e107.behaviors.vstoreCartQty = {
		attach: function (context, settings)
		{
			$(context).find('.cart-qty').once('vstore-cart-qty').each(function ()
			{
				var $this = $(this);

				$this.keyup(function ()
				{
					$("#cart-qty-submit").show(0);
					$("#cart-checkout").hide(0);
				});
			});
		}
	};

	/**
	 * add item to cart via ajax
	 * @type {{attach: e107.behaviors.vstoreCartAdd.attach}}
	 */
	e107.behaviors.vstoreCartAdd = {
		attach: function (context, settings)
		{
			$(context).find('.vstore-add').once('vstore-cart-add').each(function (e)
			{
				$(this).click(function(e){
					e.preventDefault();

					if ($(this).hasClass('disabled'))
					{
						return;
					}

					var url = settings.vstore.cart.url;
					var itemid = $(this).data('vstore-item');

					url += (url.indexOf('?')>=0 ? '&' : '?') + 'mode=cart&add=' + itemid;


					if ($('#vstore-item-vars-' + itemid).length>0)
					{
						$('select.vstore-item-var').each(function(i, v){

							if ($(v).data('id') == itemid)
							{
								var $option = $('#' + $(v).attr('id') + ' option:selected');
								if ($option.data('type')!= '' && $option.val() != '')
								{
									url += '&itemvar[]=' + encodeURIComponent($option.data('id') + '-' + $option.val());
								}
							}

						});
					}
					

					$.get(url, function(resp){
						var msg = (typeof resp != 'undefined') ? resp : '';
						if (msg.substr(0, 2) == 'ok')
						{
							// if ok, update cart menu with new content
							msg = msg.substr(2);
							$('#vstore-cart-dropdown').replaceWith(msg);
							var itemcount = $('#vstore-item-count').text();
							if (itemcount <= 0) itemcount = 0;
							$('#vstore-cart-icon .badge').html(itemcount);
							return;
						}
						// Print our any (error) message 
						$('#uiAlert').html(msg);

					});
				});
			});
		}
	};


	/**
	 * Update price on variation change
	 */
	e107.behaviors.vstorePriceUpdate = {
		attach: function (context, settings)
		{
			$(context).find('select.vstore-item-var').once('vstore-price-update').each(function (e)
			{
				$(this).change(function(e){
					var itemid = $(this).data('id');
					var baseprice = parseFloat($('.vstore-item-baseprice-'+itemid).text());
					var varprice = baseprice;
					var itemvars = [];

					$('select.vstore-item-var').each(function(i, v){

						if ($(v).data('id') == itemid)
						{
							var $option = $('#' + $(v).attr('id') + ' option:selected');
							itemvars.push($(v).val());
							var val = parseFloat($option.data('val'));
							if (val > 0.0)
							{
								switch($option.data('op'))
								{
									case '%':
										varprice += baseprice * (val / 100.0);
										break;
									case '+':
										varprice += val;
										break;
									case '-':
										varprice -= val;
										break;
								}
							}
						}

					});
					
					var inStock = vstoreCheckInventory(itemid, itemvars);
					if (inStock)
					{
						$('.vstore-add-item-' + itemid).removeClass('btn-default disabled').addClass('btn-success').html('<span class="glyphicon glyphicon-shopping-cart"></span> ' + settings.vstore.cart.addtocart);
						$('.vstore-item-avail-' + itemid).removeClass('label-danger').addClass('label-success').html(settings.vstore.cart.available);
					}
					else
					{
						$('.vstore-add-item-' + itemid).removeClass('btn-success').addClass('btn-default disabled').html(settings.vstore.cart.outofstock);
						$('.vstore-item-avail-' + itemid).removeClass('label-success').addClass('label-danger').html(settings.vstore.cart.outofstock);
					}

					$('.vstore-item-price-'+itemid).text(varprice.toFixed(2));

				});
			});
		}
	};



	/**
	 * add active class to selected payment type
	 */
	e107.behaviors.vstoreSetGateway = {
		attach: function (context, settings)
		{
			$(context).find('.vstore-gateway-radio').once('vstore-set-gateway').each(function (e)
			{

				$(this).change(function(){
					$(".vstore-gateway").removeClass("active");
					$(this).parent().addClass("active");
				});
			});
		}
	}

})(jQuery);

/** 
 * Reset/empty cart and update menu
 */
function vstoreCartReset()
{
	var url = e107.settings.vstore.cart.url;

	url += (url.indexOf('?')>=0 ? '&' : '?') + 'reset=1';
	

	$.get(url, function(resp){
		var msg = (typeof resp != 'undefined') ? resp : '';
		if (msg.substr(0, 2) == 'ok')
		{
			// if ok, update cart menu with new content
			msg = msg.substr(2);
			$('#vstore-cart-dropdown').replaceWith(msg);
			$('#vstore-cart-icon .badge').html(0);
			return;
		}
	});

};

/**
 * Refresh cart menu item
 */
function vstoreCartRefresh()
{
	var url = e107.settings.vstore.cart.url;

	url += (url.indexOf('?')>=0 ? '&' : '?') + 'refresh=1';
	

	$.get(url, function(resp){
		var msg = (typeof resp != 'undefined') ? resp : '';
		if (msg.substr(0, 2) == 'ok')
		{
			// if ok, update cart menu with new content
			msg = msg.substr(2);
			$('#vstore-cart-dropdown').replaceWith(msg);
			var itemcount = $('#vstore-item-count').text();
			if (itemcount <= 0) itemcount = 0;
			$('#vstore-cart-icon .badge').html(itemcount);
			return;
		}
	});

};

/**
 * Check if the given iten or item/itemvar combination is in stock
 * @param {int} itemid 
 * @param {array} itemvars 
 */
function vstoreCheckInventory(itemid, itemvars)
{
	if (typeof itemid == 'undefined' || parseInt(itemid, 10) <= 0)
	{
		return false;
	}
	var stock = e107.settings.vstore.stock['x'+itemid];
	if (typeof stock == 'undefined')
	{
		return false;
	}

	var result = 0;
	if (typeof itemvars == 'undefined')
	{
		result = stock;
	}
	else if ($.isArray(itemvars))
	{
		if (itemvars.length == 1)
		{
			var x = itemvars[0];
			result = stock[x];
		}
		else if (itemvars.length == 2)
		{
			var x = itemvars[0];
			var y = itemvars[1];
			result = stock[x][y];
		}
		else
		{
			restult = 0;
		}

	}

	if (typeof result == 'undefined')
	{
		return 0;
	}


	if ($.isNumeric(result) && result != 0)
	{
		return true;
	}
	return false;

}