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
        },
        hide_add: function()
        {
            $('#mdl_nutri').modal('hide');
        }
    };

    nutri.ajax = {
        do_save: function(data, cb){

            var url = 'services/save_nutrition',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_nutrition: function(vn, cb){

            var url = 'services/get_nutrition',
                params = {
                    vn: vn
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
    };

    $('a[data-name="btn_nutri"]').click(function(){
        var vn = $('#vn').val();

        nutri.ajax.get_nutrition(vn, function(err, data){
            if(err)
            {
                app.alert(err);
            }
            else
            {
                if(data)
                {
                    $('#txt_nutri_headcircum').val(data.rows.headcircum);
                    $('#sl_childdevelop').val(data.rows.childdevelop);
                    $('#sl_food').val(data.rows.food);
                    $('#sl_bottle').val(data.rows.bottle);
                }
                else
                {
                    app.alert('ไม่มีข้อมูลในวันนี้');
                }
            }
        });

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

        data.vn = $('#vn').val();

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
            nutri.ajax.do_save(data, function(err){
               if(err)
               {
                   app.alert(err);
               }
               else
               {
                   app.alert('บันทึกรายการเสร็จเรียบร้อยแล้ว');
                   nutri.modal.hide_add();
               }
            });
        }

    });
});