head.ready(function(){
	var fp = {};

    fp.hn = $('#hn').val();
    fp.vn = $('#vn').val();
	
	fp.modal = {
        show_new: function()
        {
            app.load_page($('#mdl_fp'), '/pages/fp/' + fp.hn + '/' + fp.vn, 'assets/apps/js/pages/fp.js');
            $('#mdl_fp').modal({keyboard: false});
        }
	};
	
	$('a[data-name="btn_fp"]').click(function(){
		fp.modal.show_new();
	});

});