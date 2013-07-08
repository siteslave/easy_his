/**
 * Nutrition script
 */
head.ready(function(){

    var nutri = {};
    nutri.hn = $('#hn').val();
    nutri.vn = $('#vn').val();

    nutri.modal = {
        show_new: function(){
            app.load_page($('#mdl_nutri'), '/pages/nutrition/' + nutri.hn + '/' + nutri.vn, 'assets/apps/js/pages/nutrition.js');
            $('#mdl_nutri').modal({keyboard: false});
        }
    };

    $('a[data-name="btn_nutri"]').click(function(){
        nutri.modal.show_new();
    });

});