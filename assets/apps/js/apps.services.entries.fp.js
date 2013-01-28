head.ready(function(){
	var fp = {};
	
	fp.modal = {
		show_fp: function()
		{
            $('#mdl_fp').modal({
                backdrop: 'static'
            }).css({
                    width: 960,
                    'margin-left': function() {
                        return -($(this).width() / 2);
                    }
                });
        }
	};
	
	fp.ajax = {
		save_fp: function(data, cb)
		{
            var url = 'services/save_fp',
                params = {
                    data: data
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_list: function(vn, cb)
		{
            var url = 'services/get_fp_list',
                params = {
            		vn: vn
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        },
        get_list_all: function(hn, cb)
		{
            var url = 'services/get_fp_list_all',
                params = {
            		hn: hn
                };

            app.ajax(url, params, function(err, data){
                return err ? cb(err) : cb(null, data);
            });
        }
	};
	
	fp.get_list = function()
	{
		var vn = $('#vn').val();
		
		fp.ajax.get_list(vn, function(err, data){
			if(err)
			{
				app.alert(err);
			}
			else
			{
				$('#tbl_fp_list > tbody').empty();
				
				_.each(data.rows, function(v){
					$('#tbl_fp_list > tbody').append(
							'<tr>' +
							'<td>'+v.fp_name+'</td>' +
							'<td>'+v.provider_name+'</td>' +
							'<tr>'
							);
				});
			}
		});
	};
	
	fp.get_list_all = function()
	{
		var hn = $('#hn').val();
		
		fp.ajax.get_list_all(hn, function(err, data){
			$('#tbl_fp_list_all > tbody').empty();
			
			if(err)
			{
				app.alert(err);
				$('#tbl_fp_list_all > tbody').append('<tr><td colspan="6">ไม่พบรายการ</td></tr>');
			}
			else
			{
				_.each(data.rows, function(v){
					$('#tbl_fp_list_all > tbody').append(
							'<tr>' +
							'<td>'+app.to_thai_date(v.date_serv)+'</td>' +
							'<td>'+v.time_serv+'</td>' +
							'<td>'+v.clinic_name+'</td>' +
							'<td>'+v.owner_name+'</td>' +
							'<td>'+v.fp_name+'</td>' +
							'<td>'+v.provider_name+'</td>' +
							'<tr>'
							);
				});
			}
		});
	};
	
	$('a[data-name="btn_fp"]').click(function(){
	
		fp.get_list();
		fp.modal.show_fp();
		
	});
	
	//save fp
	$('#btn_do_save_fp').click(function(){
		var data = {};
		
		data.fp_type = $('#sl_fp_type').val();
		data.vn = $('#vn').val();
		data.hn = $('#hn').val();
		
		if(!data.fp_type)
		{
			app.alert('กรุณาระบุประเภทการคุมกำเนิด');
		}
		else if(!data.vn)
		{
			app.alert('กรุณาระบุเลขที่รับบริการ (VN)');
		}
		else if(!data.hn)
		{
			app.alert('กรุณาระบุ HN');
		}
		else
		{
			fp.ajax.save_fp(data, function(err){
				if(err)
				{
					app.alert(err);
				}
				else
				{
					app.alert('บันทึกข้อมูลเสร็จเรียบร้อยแล้ว');
					 fp.get_list();
				}
			});
		}	
	});
	
	$('a[href="#fp_tab2"]').click(function(){
		fp.get_list_all();
	});
});