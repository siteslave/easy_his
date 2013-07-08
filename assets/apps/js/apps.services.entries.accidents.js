/*
 * Accident module
 */
head.ready(function(){
	var accident = {};

    accident.modal = {
        show_entry: function() {
            $('#mdl_accident').modal({keyboard: false});
        },
        hide_entry: function() {
            $('#mdl_accident').modal('hide');
        }
    };

	accident.ajax = {
		do_save: function(data, cb){
			var url = 'services/save_accident',
            params = {
                data: data
            };
			//Do load ajax.
	        app.ajax(url, params, function(err, data){
	            return err ? cb(err) : cb(null, data);
	        });
		},
		get_data: function(vn, cb){
			var url = 'services/get_accident_data',
            params = {
                vn: vn
            };
	        app.ajax(url, params, function(err, data){
	            return err ? cb(err) : cb(null, data);
	        });
		},
		remove: function(vn, cb){
			var url = 'services/remove_accident',
            params = {
                vn: vn
            };
	        app.ajax(url, params, function(err, data){
	            return err ? cb(err) : cb(null, data);
	        });
		}
	};
	
	$('#btn_save_accident').click(function(){
		var data = {};
	
		data.vn 				= $('#vn').val();
		data.hn 				= $('#hn').val();
		data.ae_date 			= $('#txt_aedate').val();
		data.ae_time 			= $('#txt_aetime').val();
		data.ae_urgency 		= $('#sl_aeurgency').val();
		data.ae_type 			= $('#sl_aetype').val();
		data.ae_place 			= $('#sl_aeplace').val();
		data.ae_typein 			= $('#sl_aetypein').val();
		data.ae_traffic 		= $('#sl_aetraffic').val();
		data.ae_vehicle 		= $('#sl_aevehicle').val();
		data.ae_alcohol 		= $('#sl_aealcohol').val();
		data.ae_nacrotic_drug 	= $('#sl_aenacrotic_drug').val();
		data.ae_belt 			= $('#sl_aebelt').val();
		data.ae_helmet 			= $('#sl_aehelmet').val();
		data.ae_airway 			= $('#sl_aeairway').val();
		data.ae_stopbleed 		= $('#sl_aestopbleed').val();
		data.ae_splint 			= $('#sl_aesplint').val();
		data.ae_fluid 			= $('#sl_aefluid').val();
		data.ae_coma_eye 		= $('#txt_aecoma_eye').val();
		data.ae_coma_speak 		= $('#txt_aecoma_speak').val();
		data.ae_coma_movement 	= $('#txt_aecoma_movement').val();
		
		if(!data.vn){
			app.alert('ไม่พบเลขที่รับบริการ (VN)');
		}else if(!data.hn){
			app.alert('ไม่พบข้อมูลผู้รับบริการ');
		}else if(!data.ae_date){
			app.alert('กรุณาระบุวันที่เกิดอุบัติเหตุ');
		}else if(!data.ae_time){
			app.alert('กรุณาระบุเวลาเกิดอุบัติเหตุ');
		}else if(!data.ae_urgency){
			app.alert('กรุณาระบุความเร่งด่วน');
		}else if(!data.ae_type){
			app.alert('กรุณาระบุประเภทผู้ป่วยอุบัติเหตุ');
		}else if(!data.ae_place){
			app.alert('กรุณาระบุสถานที่เกิดอุบัติเหตุ');
		}else if(!data.ae_typein){
			app.alert('กรุณาระบุประเภทการมารับบริการ');
		}else if(!data.ae_traffic){
			app.alert('กรุณาระบุประเภทของผู้บาดเจ็บ');
		}else if(!data.ae_vehicle){
			app.alert('กรุณาระบุประเภทยานพาหนะที่เกิดอุบัติเหตุ');
		}else if(!data.ae_alcohol){
			app.alert('กรุณาระบุการดื่มแอลกอฮอลล์');
		}else if(!data.ae_nacrotic_drug){
			app.alert('กรุณาระบุการใช้สารเสพติด');
		}else if(!data.ae_belt){
			app.alert('กรุณาระบุการคาดเข็มขัดนิรภัย');
		}else if(!data.ae_helmet){
			app.alert('กรุณาระบุการใส่หมวกนิรภัย');
		}else if(!data.ae_airway){
			app.alert('กรุณาระบุการดูแลการหายใจ');
		}else if(!data.ae_stopbleed){
			app.alert('กรุณาระบุการห้ามเลือด');
		}else if(!data.ae_splint){
			app.alert('กรุณาระบุการใส่ splint/slab');
		}else if(!data.ae_fluid){
			app.alert('กรุณาระบุการให้น้ำเกลือ');
		}else{
			
			data.isupdate = $('#isupdate').val();
			
			accident.ajax.do_save(data, function(err){
				if(err){
					app.alert(err);
				}else{
					app.alert('การบันทึกข้อมูลเสร็จเรียบร้อบแล้ว');
                    accident.modal.hide_entry();
				}
			});
		}
	});
	
	accident.set_data = function(data){
		var data = data.rows;
		
		$('#txt_aedate').val(data.ae_date);
		$('#txt_aetime').val(data.ae_time);
		$('#sl_aeurgency').val(data.ae_urgency);
		$('#sl_aetype').val(data.ae_type);
		$('#sl_aeplace').val(data.ae_place);
		$('#sl_aetypein').val(data.ae_typein);
		$('#sl_aetraffic').val(data.ae_traffic);
		$('#sl_aevehicle').val(data.ae_vehicle);
		$('#sl_aealcohol').val(data.ae_alcohol);
		$('#sl_aenacrotic_drug').val(data.ae_nacrotic_drug);
		$('#sl_aebelt').val(data.ae_belt);
		$('#sl_aehelmet').val(data.ae_helmet);
		$('#sl_aeairway').val(data.ae_airway);
		$('#sl_aestopbleed').val(data.ae_stopbleed);
		$('#sl_aesplint').val(data.ae_splint);
		$('#sl_aefluid').val(data.ae_fluid);
		$('#txt_aecoma_eye').val(data.ae_coma_eye);
		$('#txt_aecoma_speak').val(data.ae_coma_speak);
		$('#txt_aecoma_movement').val(data.ae_coma_movement);
	};
	
	$('#btn_accident').on('click', function() {
        //get detail
        var vn = $('#vn').val();
        accident.ajax.get_data(vn, function(err, data) {
            if(err)
            {
                app.alert(err);
            }
            else
            {
                accident.set_data(data);
            }

            accident.modal.show_entry();
        });
    });

    //remove
    $('#btn_remove_accident').on('click', function() {
        var vn = $('#vn').val();
        app.confirm('คุณต้องการลบข้อมูลอุบัติเหตุนี้ ใช่หรือไม่?', function(res) {
            if(res)
            {
                accident.ajax.remove(vn, function(err) {
                    if(err)
                    {
                        app.alert(err);
                    }
                    else
                    {
                        app.alert('ลบรายการเสร็จเรียบร้อยแล้ว');
                        accident.modal.hide_entry();
                    }
                });
            }
        });
    });

});

//End file