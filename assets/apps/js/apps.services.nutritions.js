/**
 * Nutrition script
 */
head.ready(function(){

    var nutri = {};

    nutri.modal = {
        add_nutrition: function(){
            $('#mdl_nutri').modal({
                backdrop: 'static'
            }).css({
                    width: 960,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        }
    };

    nutri.ajax = {
        do_save: function(data, cb){

            var url = 'services/save_nutri',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };

    $('a[data-name="btn_nutri"]').click(function(){
        nutri.modal.add_nutrition();
    });

    $('#btn_nutri_save').click(function(){
        var data = {};
        data.height = $('#txt_screening_height').val();
        data.weight = $('#txt_screening_weight').val();
        data.headcircum = $('#txt_nutri_headcircum').val();
        data.childdevelop = $('#sl_childdevelop').val();
        data.food = $('#sl_food').val();
        data.bottle = $('#sl_bottle').val();

        if(!data.height)
        {
            app.alert('กรุณาระบุส่วนสูง [หน้าคัดกรอง]');
        }
        else if(!data.weight)
        {
            app.alert('กรุณาระบุน้ำหนัก [หน้าคัดกรอง]');
        }
        else if(!data.headcircum)
        {
            app.alert('กรุณาระบุเส้นรอบศีรษะ');
        }
        else if(!data.childdevelop)
        {
            app.alert('กรุณาระบุดรับดับพัฒนาการ');
        }
        else if(!data.food)
        {
            app.alert('กรุณาระบุอาหารที่รับประทาน');
        }
        else if(!data.bottle)
        {
            app.alert('กรุณาระบุการใช้ขวดนม');
        }
        else
        {
            //do save
            nutri.ajax.do_save(data, function(err, data){
                
            });
        }

    });
});