/*
 * Main appointment library.
 * 
 * @author		Mr.Satit Rianpit <mr.satit@outlook.com>
 * @copyright	Copyright 2013. Allright reserved.
 * @license		http://his.mhkdc.com
 */

head.ready(function(){
	//------------------------------------------------------------------------------------------------------------------
	//Appointment object.
	var appoint = {};
	//------------------------------------------------------------------------------------------------------------------
	// Modal object
	appoint.modal = {
			show_search_visit: function(){
	            $('#mdl_select_visit').modal({
	                backdrop: 'static'
	            }).css({
	                    width: 780,
	                    'margin-left': function() {
	                        return -($(this).width() / 2);
	                    }
	                });
	        },
	        hide_new: function(){
	            $('#mdl_select_visit').modal('hide');
	        }
	};
	//------------------------------------------------------------------------------------------------------------------
	// Ajax object.
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
		},
		search_visit: function(query, filter, cb){
			var url = 'appoints/search_visit',
            params = {
                query: query,
                filter: filter
            };
			//Do load ajax.
	        app.ajax(url, params, function(err, data){
	            return err ? cb(err) : cb(null, data);
	        });
		},
		remove: function(id, cb){
			var url = 'appoints/remove',
            params = {
                id: id
            };
			//Do load ajax.
	        app.ajax(url, params, function(err, data){
	            return err ? cb(err) : cb(null, data);
	        });
		}
	};
	//------------------------------------------------------------------------------------------------------------------
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
	//------------------------------------------------------------------------------------------------------------------
	//Set appointment list.
	appoint.set_list = function(data){
		_.each(data.rows, function(v){
			var vstatus = v.vstatus == '1' ? '<span class="label label-success" title="มาตามนัด">มาตามนัด</span>' :
				'<span class="label label-warning" title="ไม่มาตามนัด">ไม่มาตามนัด</span>';
			
			$('#tbl_appoint_list > tbody').append(
					'<tr>' +
					'<td>' + vstatus + '</td>' +
					'<td>' + app.mongo_to_thai_date(v.apdate) + '</td>' +
					'<td>' + v.aptime + '</td>' +
					'<td>' + v.hn + '</td>' +
					'<td>' + v.person_name + '</td>' +
					'<td>' + v.aptype_name + '</td>' +
					'<td>' + v.clinic_name + '</td>' +
					'<td>' + v.provider_name + '</td>' +
					'<td><div class="btn-group">' +
					'<a href="javascript:void(0);" class="btn"><i class="icon-edit"></i></a>' +
					'<a href="javascript:void(0);" data-name="btn_remove" data-id="' + v.id + '" class="btn"> '+
					'<i class="icon-trash"></i></a>' +
					'</div></td>' +
					'</tr>'
					);
		});
	};
	//------------------------------------------------------------------------------------------------------------------
	//Do filter.
	$('button[data-name="btn_do_filter"]').click(function(){
		var id = $(this).attr('data-id');
		$('#txt_status').val(id);
		
		appoint.get_list();
	});
	//------------------------------------------------------------------------------------------------------------------
	$('#btn_show_visit').click(function(){
		appoint.modal.show_search_visit();
	});
	//------------------------------------------------------------------------------------------------------------------
	//Set search visit filter.
	$('a[data-name="btn_set_search_visit_filter"]').click(function(){
		var v = $(this).attr('data-value');
		
		$('#txt_search_visit_by').val(v);
	});
	
	//------------------------------------------------------------------------------------------------------------------
	//Search visit
	$('#btn_do_search_visit').click(function(){
		var query = $('#txt_query_visit').val(),
			filter = $('#txt_search_visit_by').val();
		
		if(!query){
			app.alert('กรุณาระบุคำที่ต้องการค้นหา');
		}else{
			appoint.ajax.search_visit(query, filter, function(err, data){
				$('#tbl_search_visit_result > tbody').empty();
				if(err){
					app.alert(err);
				}else{
					_.each(data.rows, function(v){
					
						$('#tbl_search_visit_result > tbody').append(
								'<tr>' +
								'<td>'+ v.vn +'</td>' +
								'<td>'+ v.date_serv +'</td>' +
								'<td>'+ v.time_serv +'</td>' +
								'<td>'+ v.clinic_name +'</td>' +
								'<td><a href="javascript:void(0);" class="btn" data-name="btn_selected_visit" ' +
								'data-vn="'+ v.vn +'" data-hn="'+ v.hn +'"><i class="icon-ok"></i></a></td>' +
								'</tr>'
						);
					});
				}
			});
		}
	});
	
	/*
	 * '<td><a href="javascript:void(0);" class="btn" data-name="btn_selected_visit" ' +
								'data-vn="'+ v.vn +'" data-hn="'+ v.hn +'"><i class="icon-ok"></i></a></td>' +
	 */
	
	$(document).on('click', 'a[data-name="btn_selected_visit"]', function(){
		var hn = $(this).attr('data-hn'),
			vn = $(this).attr('data-vn');
		
		app.go_to_url('appoints/register/' + vn + '/' + hn);
	});
	
	//------------------------------------------------------------------------------------------------------------------
	/*
	 * Remove appointment
	 */
	$(document).on('click', 'a[data-name="btn_remove"]', function(){
		var id = $(this).attr('data-id'),
			obj = $(this).parent().parent().parent();
		
		app.confirm('คุณต้องการลบรายการใช่หรือไม่?', function(res){
			if(res){
				appoint.ajax.remove(id, function(err){
					if(err){
						app.alert(err);
					}else{
						app.alert('ลบรายการเสร็จเรียบร้อยแล้ว');
						obj.fadeOut('slow');
					}
				});
			}
		});
	});
});

//End file