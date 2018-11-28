jQuery(document).ready(function($) {
    if ($('.cabi_player_card__carriera_sportiva').length) {
		$('.cabi_player_card__carriera_sportiva').each(function() {
			$(this).on('click', function(){		
				var span = $(this).children('.cabi_player_card__carriera_title').children('span');
				var descrizione = $(this).children('.cabi_player_card__carriera_descrizione');
				descrizione.slideToggle();
				if (descrizione.height() == 1) span.html('<i class="fa fa-minus"></i>');
				else span.html('<i class="fa fa-plus"></i>');
			});
		});
		
	}
});