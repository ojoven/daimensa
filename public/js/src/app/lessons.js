// ================================
// LESSONS
// ================================
// Functions related to lessons (YouTube videos, etc.)

// VARS
var $lessonContainer = $('.lesson-container');

// LOGIC
$(function() {

	// Just load if on logged in home page
	if ($lessonContainer.length > 0) {
		loadLesson();
	}

});

// FUNCTIONS
function loadLesson() {

	var data = {};

	var url = urlBase + "/html/loadlesson";
	$.get(url, data, function(html) {

		$lessonContainer.html(html);

	});

}