/**
 * Service Special PP script
 */
head.ready(function(){
    var spp = {};

    spp.modal = {
        show_new: function(hn, vn)
        {
            app.load_page($('#mdl_special_pp'), '/pages/special_pp/' + hn + '/' + vn, 'assets/apps/js/pages/special_pp.js');
            $('#mdl_special_pp').modal({keyboard: false});
        }
    };

    $('a[data-name="btn_specialpp"]').click(function(){
        var vn = $('#vn').val(),
            hn = $('#hn').val();

        spp.modal.show_new(hn, vn);
    });

});
//End file