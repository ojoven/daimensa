// ================================
// LOGIN
// ================================
// Functions related to log in

// VARS
var $toLoginFacebook = $('#to-login-facebook');

// LOGIC
$(function() {

	loginFacebook();

});

// FUNCTIONS
function loginFacebook() {

	$toLoginFacebook.on('click', function() {

		var $selector = $(this);

		// Loader
		startProgressButton($selector);

		// Log in with Facebook
		FB.login(function(responseFacebookLogin) {

			if (responseFacebookLogin && responseFacebookLogin.authResponse) {

				FB.api('/me?fields=id,name,email', function(responseFacebookMe) {

					var data = {};
					data.facebook_id = responseFacebookMe.id;
					data.name = responseFacebookMe.name;
					data.email = responseFacebookMe.email;

					var url = urlBase + "/api/loginfacebook";
					$.post(url, data, function(response) {

						stopProgressButton($selector);

						// If success
						if (response.success) {

							var url;

							// If settings configured we take the user to home page
							if (response.settings) {
								url = urlBase;
							} else {
								// We take the user to the settings page
								url = urlBase + '/user';
							}

							goto(url);

						}
					});

				});

			}

		}, {scope: "email"});

		return false;

	});

}