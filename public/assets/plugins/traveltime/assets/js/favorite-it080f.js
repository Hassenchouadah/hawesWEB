jQuery(document).ready( function($) {	
	$('.favorite-it').on('click', function() {	
	    var $this = $(this);
		if($this.hasClass('favorited')) {
			alert(favorite_it_vars.already_favorited_message);
			return false;
		}	
		var post_id = $this.data('post-id');
		var user_id = $this.data('user-id');
		if (user_id == '0') {
			alert(favorite_it_vars.user_logged_in);
		}

		var post_data = {
			action: 'favorite_it',
			item_id: post_id,
			user_id: user_id,
			favorite_it_nonce: favorite_it_vars.nonce
		};
		$.post(favorite_it_vars.ajaxurl, post_data, function(response) {
			if(response == 'favorited') {
			    $this.addClass('favorited');
			    alert(favorite_it_vars.favorited_message);
			} else {
				alert(favorite_it_vars.error_message);
			}
		});
		return false;
	});
	$('.favorited').on('click', function() {
	    //alert(favorite_it_vars.already_favorited_message);
	    var $this = $(this);
	    var post_id = $this.data('post-id');
	    var user_id = $this.data('user-id');
	    var post_data = {
	        action: 'unfavorite_it',
	        item_id: post_id,
	        user_id: user_id,
	        favorite_it_nonce: favorite_it_vars.nonce
	    };
	    $.post(favorite_it_vars.ajaxurl, post_data, function (response) {
	        if (response == 'unfavorited') {
	            $this.removeClass('favorited');
	            $this.addClass('favorite-it');
	            alert(favorite_it_vars.unfavorited_message);
	        } else {
	            alert(favorite_it_vars.error_message);
	        }
	    });
	    
	    return false;
	});
});