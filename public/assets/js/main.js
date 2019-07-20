window.addEventListener('load', () => {
	var offset_cntr = 0;
	var post_num_cntr = 1;
	var nav_buttons = document.querySelectorAll('.click');
	nav_buttons.forEach(nav_btn => {
		var new_href = window.location.href + '&offset='+ offset_cntr+++'&post_num='+ post_num_cntr+++'';
			nav_btn.href = new_href;
	});
});


