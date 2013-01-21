head.ready(function(){
	//Appointment object.
	var appoint = {};
	
	appoint.ajax = {
		get_list: function(apdate, apclinic, apstatus, cb){
			var url = 'appoints/get_list',
            params = {
                apdate: 	apdate,
                apclinic: 	apclinic,
                apstatus: 	apstatus
            };
			//Do load ajax.
	        app.ajax(url, params, function(err, data){
	            return err ? cb(err) : cb(null, data);
	        });
		}
	};
	
	//Get appointment list.
	appoint.get_list = function(){
		var apdate 		= $('#txt_date').val(),
			apclinic 	= $('#sl_clinic').val(),
			apstatus 	= $('#txt_status').val();
		
		if(!apdate){
			app.alert('กรุณาระบุวันที่');
		}else{
			//Load appointment with ajax.
			appoint.ajax.get_list(apdate, apclinic, apstatus, function(err, data){
				$('#tbl_appoint_list > tbody').empty();
				
				if(err){
					app.alert(err);
				}else{
					appoint.set_list(data);
				}
			});
		}
		
	};
	
	//Set appointment list.
	appoint.set_list = function(data){
		_.each(data.rows, function(v){
			$('#tbl_appoint_list > tbody').append(
					'<tr>' +
					'<td>' + app.mongo_to_thai_date(v.apdate) + '</td>' +
					'<td>' + v.aptime + '</td>' +
					'<td>' + v.hn + '</td>' +
					'<td>' + v.person_name + '</td>' +
					'<td>' + v.aptype_name + '</td>' +
					'<td>' + v.clinic_name + '</td>' +
					'<td>' + v.provider_name + '</td>' +
					'</tr>'
					);
		});
	};
	
	//Do filter.
	$('button[data-name="btn_do_filter"]').click(function(){

		var id = $(this).attr('data-id');
		$('#txt_status').val(id);
		
		appoint.get_list();
	});
});