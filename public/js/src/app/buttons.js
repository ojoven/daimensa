// ================================
// BUTTONS
// ================================
// Functions related to buttons

// FUNCTIONS

// Start Progress Button
function startProgressButton($selector) {

	$selector.attr('disabled', 'disabled');
	$selector.addClass('in-progress');

}

// Stop Progress Button
function stopProgressButton($selector) {

	$selector.removeAttr('disabled');
	$selector.removeClass('in-progress');

}