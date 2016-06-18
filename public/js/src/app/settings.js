// ================================
// SETTINGS
// ================================
// Functions related to settings

// VARS
var $toSaveSettings = $('#to-save-settings' ),
	$settingsMotherTongue = $('#settings_mother_tongue'),
	$settingsLanguages = $('#settings_languages');

// LOGIC
$(function() {

	saveSettings();

});

// FUNCTIONS
function saveSettings() {

	$toSaveSettings.on('click', function() {

		var $selector = $(this);

		// Loader
		startProgressButton($selector);

		var data = {};
		data.mother_tongue = $settingsMotherTongue.val();
		data.languages = $settingsLanguages.val();

		var url = urlBase + "/api/savesettings";
		$.post(url, data, function(response) {

			stopProgressButton($selector);

			// If success
			if (response.success) {

				window.location.href = urlBase;

			} else {
				showError($selector, response.errors);
			}
		});


		return false;

	});

}