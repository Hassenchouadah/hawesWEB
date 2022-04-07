jQuery(document).ready(function ($) {

	$('#login_form .status, #signUp_form .status').hide();
    // Display form from link inside a popup
	/*
	$('#signUp_form #pop_login, #login_form #pop_signup').live('click', function (e) {
        formToFadeOut = $('#signUp_form');
        formtoFadeIn = $('#login_form');

        if ($(this).attr('id') == 'pop_signup') {
            formToFadeOut = $('#login_form');
            formtoFadeIn = $('#signUp_form');
        }

        formToFadeOut.fadeOut(500, function () {
            formtoFadeIn.fadeIn();
        })

        return false;
    });


	$('form#forgot_password #pop_login2').live('click', function (e) {
        formToFadeOut = $('form#forgot_password');
        formtoFadeIn = $('#login_form');

        formToFadeOut.fadeOut(500, function () {
            formtoFadeIn.fadeIn();
        })

        return false;
    });
	*/

    	

	// Display lost password form 

	$('#pop_forgot').on('click', function () {
		formToFadeOut = $('#login_form');
		formtoFadeIn = $('form#forgot_password');
		formToFadeOut.fadeOut(500, function () {
        	formtoFadeIn.fadeIn();
		})

		return false;
	});

	

	// Close popup

    $(document).on('click', '.login_overlay, .close', function () {
		$('#login_form, #signUp_form, form#forgot_password').fadeOut(500, function () {
            $('.login_overlay').remove();
        });

        return false;
    });



    // Show the login/signup popup on click
	/*
    $('#show_login, #show_signup').on('click', function (e) {
        $('body').prepend('<div class="login_overlay"></div>');

        if ($(this).attr('id') == 'show_login') 
			$('#login_form').fadeIn(500);
        else 
			$('#signUp_form').fadeIn(500);
        e.preventDefault();
    });
	*/


	// Perform AJAX login/register on form submit

	$('#login_form, #signUp_form').on('submit', function (e) {

        //if (!$(this).valid()) return false;
        $('p.status', this).show().text(ajax_auth_object.loadingmessage);

		if ($(this).attr('id') == 'login_form') {
			$('#login_form .status').show();
			action = 'ajaxlogin';
			username = $('#login_form #username').val();
			password = $('#login_form #password').val();
			email = '';
			security = $('#login_form #security').val();
		}
		if ($(this).attr('id') == 'signUp_form') {
			$('#signUp_form .status').show();
			action = 'ajaxregister';
			username = $('#signonname').val();
			password = $('#signonpassword').val();
        	email = $('#email').val();
        	security = $('#signonsecurity').val();	
		}  

		ctrl = $(this);

		$.ajax({

            type: 'POST',
            dataType: 'json',
            url: ajax_auth_object.ajaxurl,

            data: {
                'action': action,
                'username': username,
                'password': password,
				'email': email,
                'security': security
            },

            success: function (data) {

				$('p.status', ctrl).text(data.message);

				if (data.loggedin == true) {
                    document.location.href = ajax_auth_object.redirecturl;
                }
            }

        });

        e.preventDefault();
    });

	

	// Perform AJAX forget password on form submit

	$('form#forgot_password').on('submit', function(e){

		if (!$(this).valid()) return false;

		$('p.status', this).show().text(ajax_auth_object.loadingmessage);

		user_login = $('form#forgot_password #user_signedin').val();

		ctrl = $(this);

		$.ajax({
			type: 'POST',
            dataType: 'json',
            url: ajax_auth_object.ajaxurl,

			data: { 
				'action': 'ajaxforgotpassword', 
				'user_login': user_login, 
				'security': $('#forgotsecurity').val(), 
			},

			success: function(data){					
				$('p.status',ctrl).text(data.message);				
			}

		});

		e.preventDefault();

		return false;
	});

	

	// Client side form validation
	/*
    if (jQuery("#register").length) 

		jQuery("#register").validate(

		{rules:{

			password2:{ equalTo:'#signonpassword' 

			}	

		}}

		);

    else if (jQuery("#login").length) 

		jQuery("#login").validate();

	if(jQuery('#forgot_password').length)

		jQuery('#forgot_password').validate();
	*/
});