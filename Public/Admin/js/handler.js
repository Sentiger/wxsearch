jQuery.extend({
	handleError : function(s, xhr, status, e) {
		if (s.error) {
			s.error(xhr, status, e);
		} else if (xhr.responseText) {
		}
	}
});
