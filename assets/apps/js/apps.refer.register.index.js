/**
 * Created By Mr.Utit Sairat.
 * E-mail: soodteeruk@gmail.com
 * Date: 13/3/2556 15:44 น.
 */
$(function() {
    var refer = {};

    refer.ajax = {
        get_local_pcu: function() {
            var url = 'refer/get_local_pcu',
                params = {};
            app.ajax(url, params, function(err, data) {
                if(data != null) {
                    if(_.size(data.rows)) {
                        var v = data.rows[0];
                        $('#tboTab1FromPcuId').val(v.code);
                        $('#tboTab1FromPcuName').val(v.name);
                    }
                }
            });
        },
        get_refer_to_pcu: function() {
            var url = 'refer/get_refer_to_pcu',
                params = {};
            app.ajax(url, params, function(err, data) {
                if(data != null) {
                    if(_.size(data.rows)) {
                        var v = data.rows[0];
                        $('#tboTab1PcuId').val(v.code);
                        $('#tboTab1PcuName').val(v.name);
                    }
                }
            });
        },
        get_doctor_rooms: function() {
            var url = 'basic/get_doctor_room',
                params = {};
            app.ajax(url, params, function(err, data) {
                $('#cboTab1ReferRoom').empty();
                $('#cboTab1ReferRoom').append('<option value="">---</option>');
                if(data != null) {
                    if(_.size(data.rows)) {
                        _.each(data.rows, function(v) {
                            $('#cboTab1ReferRoom').append('<option value="'+ v.id +'">'+ v.name +'</option>');
                        });
                    }
                }
            });
        },
        get_clinic: function() {
            var url = 'basic/get_clinic',
                params = {};
            app.ajax(url, params, function(err, data) {
                $('#cboTab1Department').empty();
                $('#cboTab1Department').append('<option value="">---</option>');
                if(data != null) {
                    if(_.size(data.rows)) {
                        _.each(data.rows, function(v) {
                            $('#cboTab1Department').append('<option value="'+ v.id +'">'+ v.name +'</option>');
                        });
                    }
                }
            });
        },
        get_provider: function() {
            var url = 'basic/get_provider',
                params = {};
            app.ajax(url, params, function(err, data) {
                $('#cboTab1Doctor').empty();
                $('#cboTab1Doctor').append('<option value="">---</option>');
                if(data != null) {
                    if(_.size(data.rows)) {
                        _.each(data.rows, function(v) {
                            $('#cboTab1Doctor').append('<option value="'+ v.id +'">'+ v.name +'</option>');
                        });
                    }
                }
            });
        },
        clear_form: function() {
            //Tab1
            $('#tboTab1PcuId').val('');
            $('#tboTab1PcuName').val('');
            $('#tboTab1ReferNumber').val('');
            $('#cboTab1ReferPoint').val('');
            $('#cboTab1ReferRoom').val('');
            $('#cboTab1Department').val('');
            $('#cboTab1Doctor').val('');
            $('input[value="ในจังหวัด"]').prop('checked', true);
            $('input[value="ในเขต"]').prop('checked', true);
            $('#chkTab1AcceptStatus').prop('checked', false);
            $('#cboTab1TypeOfIllness').val('');
            $('#tboTab1FromPcuId').val('');
            $('#tboTab1FromPcuName').val('');
            $('#tboTab1Claim').val('');
            $('#tboTab1ClaimNumber').val('');
            $('#cboTab1TransportedType').val('');
            $('#cboTab1Emergency').val('');
            $('#cboTab1Cause').val('');
            $('#cboTab1Type').val('');
            $('#tboTab1Bp1').val('');
            $('#tboTab1Bp2').val('');
            $('#tboTab1Hr').val('');
            $('#tboTab1Pr').val('');
            $('#tboTab1Rr').val('');
            $('#tboTab1Bw').val('');
            $('#tboTab1Height').val('');
            $('#tboTab1Temp').val('');
            $('#tboTab1FirstDiag').val('');
            $('#cboTab1E1').val('');
            $('#cboTab1E2').val('');
            $('#cboTab1V1').val('');
            $('#cboTab1V2').val('');
            $('#cboTab1M1').val('');
            $('#cboTab1M2').val('');
            $('#cboTab1L').val('');
            $('#tboTab1R').val('');
            $('#cboTab1R').val('');
            $('#chkTab1Consciousness').prop('checked', false);
            $('#tboTab1Consciousness').val('');
            $('#chkTab1Death').val('');
            $('#tboTab1Cc').val('');
            $('#tboTab1Pe').val('');
            $('#chkTab1Ga').prop('checked', false);
            $('#tboTab1Ga').val('');
            $('#chkTab1Heent').prop('checked', false);
            $('#cboTab1Heent').val('');
            $('#chkTab1Heart').prop('checked', false);
            $('#tboTab1Heart').val('');
            $('#chkTab1Lung').prop('checked', false);
            $('#tboTab1Lung').val('');
            $('#chkTab1Neuro').prop('checked', false);
            $('#tboTab1Neuro').val('');
            $('#chkTab1Nurse').prop('checked', false);
            $('#chkTab1Ambulance').prop('checked', false);
            $('#dtpTab1TimeRefer').val(app.get_current_date() + ' ' + app.get_current_time() +':00');
            $('#tblTab1Nurse > tbody').empty();
            $('#tboTab1SaveReferResult').val('');
            $('#tboTab1Response').val('');
            //Tab2
            $('#chkTab2Position').prop('checked', false);
            $('#chkTab2Airway').prop('checked', false);
            $('#chkTab2Suction').prop('checked', false);
            $('#chkTab2EtTube').prop('checked', false);
            $('#chkTab2O2').prop('checked', false);
            $('#tboTab2O2').val('');
            $('#chkTab2Mask').prop('checked', false);
            $('#chkTab2Canular').prop('checked', false);
            $('#chkTab2Suture').prop('checked', false);
            $('#tboTab2Suture').val('');
            $('#chkTab2PressureDressing').prop('checked', false);
            $('#cboTab2OtherStopBleed').val('');
            $('#chkTab2Nss').prop('checked', false);
            $('#tboTab2Nss').val('');
            $('#chkTab2Rls').prop('checked', false);
            $('#tboTab2Rls').val('');
            $('#chkTab2Acetar').prop('checked', false);
            $('#tboTab2Acetar').val('');
            $('#tboTab2OtherIvFluid').val('');
            $('#chkTab2Splint').prop('checked', false);
            $('#chkTab2Sling').prop('checked', false);
            $('#chkTab2LongSpinalBoard').prop('checked', false);
            $('#chkTab2Collars').prop('checked', false);
            $('#chkTab2Cpr').prop('checked', false);
            $('#tblTab2Changes > tbody').empty();
            //Tab3
            $('#tblTab3Diag > tbody').empty();
            $('#tblTab3Proced > tbody').empty();
            //Tab4
            $('#tblTab4Laboratory > tbody').empty();
            //Tab5
            $('#tblTab5Xray > tbody').empty();
            $('#tboTab5Xray').val('');
            //Tab6
            $('#tboTab6Drug > tbody').empty();
            //Tab7
            $('#tblTab7Payment > tbody').empty();
            //Tab8
            //Tab9
            $('#tblTab9Liaison > tbody').empty();
            //Tab10
            //Tab11
            $('#cboTab11FromPcu').val('');
            $('#dtpTab11DateRefer').val(app.get_current_date() + ' ' + app.get_current_time() +':00');
            $('#cboTab11Haste').val('');
            $('#cboTab11Cause').val('');
            $('#tboTab11Cc').val('');
            $('#tboTab11Pe').val('');
            $('#tboTab11Bp1').val('');
            $('#tboTab11Bp2').val('');
            $('#tboTab11Hr').val('');
            $('#tboTab11Rr').val('');
            $('#tboTab11Bw').val('');
            $('#tboTab11Height').val('');
            $('#tboTab11Temp').val('');
            $('#tbpTab11Diag').val('');
            $('#tboTab11Step').val('');
            $('#tblTab11Diag > tbody').empty();
            $('#tblTab11Proced > tbody').empty();
            $('#tblTab11Lab > tbody').empty();
            $('#tblTab11Drug > tbody').empty();
            $('#cboTab11DistributionType').val('');
            $('#tboTab11ReferToPcuId').val('');
            $('#tboTab11ReferToPcuName').val('');
        }
    };

    refer.get_list = function() {
        refer.ajax.get_local_pcu();
        refer.ajax.get_refer_to_pcu();
        refer.ajax.get_doctor_rooms();
        refer.ajax.get_clinic();
        refer.ajax.get_provider();
    };

    $('#mainTab a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });

    $('#tboTab1PcuId').typeahead({
        ajax: {
            url: site_url + 'basic/search_hospital_ajax',
            timeout: 500,
            displayField: 'fullname',
            triggerLength: 3,
            preDispatch: function(query){
                return {
                    query: query,
                    csrf_token: csrf_token
                }
            },

            preProcess: function(data){
                if(data.success){
                    return data.rows;
                }else{
                    return false;
                }
            }
        },
        updater: function(data){
            var d = data.split('#');
            var name = d[0],
                code = d[1];

            $('#tboTab1PcuId').val(code);
            $('#tboTab1PcuName').val(name);

            return code;
        }
    });

    refer.ajax.clear_form();
    refer.get_list();
});