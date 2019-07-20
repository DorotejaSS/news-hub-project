window.addEventListener('load', () => {
	var offset_cntr = 0;
	var post_nmbr_cntr = 1;
	var nav_btns = document.querySelectorAll('.click');
	nav_btns.forEach(nav_btn => {
	var new_href = window.location.href + '&offset='+offset_cntr+++'&post_nmbr='+post_nmbr_cntr+++'';
		nav_btn.href = new_href;
	});

});


