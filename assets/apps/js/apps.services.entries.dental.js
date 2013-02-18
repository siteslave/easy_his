//Service dental
head.ready(function(){
    var dental = {};

    dental.modal = {
        show_register: function(){
            $('#mdl_dental').modal({
                backdrop: 'static'
            }).css({
                    width: 960,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        }
    };

    $('a[data-name="btn_dental"]').on('click', function(){
        dental.modal.show_register();
    })
});