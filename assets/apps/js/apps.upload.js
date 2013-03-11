$(document).ready(function(){
    var err = true;

    $('#btnSelectFile').click(function(){
        $('#userfile').trigger('click');
    });

    $('#userfile').on('change', function(){
        var file = $(this)[0];

        //console.log(file.files[0]);

        var file_name = file.files[0].name,
            file_size = file.files[0].size,
            file_type = file.files[0].type,
            file_ext = App.getFileExtension(file_name),
            chk_icon = null,
            tr = null;

        if(file_size > 4194304){
            chk_icon = '<i class="icon-remove"></i>';
            tr = '<tr class="error">';
            err = true;
        }else{
            if(file_ext.toLowerCase() == 'zip'){
                chk_icon = '<i class="icon-ok"></i>';
                tr = '<tr class="success">';
                err = false;
            }else{
                chk_icon = '<i class="icon-remove"></i>';
                tr = '<tr class="error">';
                err = true;
            }
        }


        $('#txtFileName').val(file_name);

        $('#tblFileToUpload tbody').empty();
        $('#tblFileToUpload tbody').append(
                tr +
                '<td>' + file_name + '</td>' +
                '<td>' + App.getReadableFileSizeString(file_size) + '</td>' +
                '<td>' + file_type+ '</td>' +
                '<td>' + file_ext + '</td>' +
                '<td>' + chk_icon + '</td>' +
            '</tr>'
        );
    });

    $('#frmUpload').ajaxForm({
        beforeSubmit: function(){
            if(err){
                alert('รูปแบบไฟล์ไม่ถูกต้อง กรุณาตรวจสอบ');
                return false;
            }else{
                $('#divLoading').css('display', 'inline');
                return true;
            }
        },

        success: function(data){
            if(data.success){
                alert('อัปโหลดไฟล์เสร็จเรียบร้อยแล้ว');
                $('#tblFileToUpload tbody').empty();
                $('#tblFileToUpload tbody').append(
                    '<tr>' +
                    '<td>...</td>' +
                    '<td>...</td>' +
                    '<td>...</td>' +
                    '<td>...</td>' +
                    '<td>...</td>' +
                    '</tr>');

                $('#txtFileName').val('');

                err = true;

                $('#divErrorUpload').css('display', 'none');
            }else{
                $('#txtErrorText').html(data.error.error.replace('<p>', '').replace('</p>', ''));
                $('#divErrorUpload').css('display', 'inline');
            }
            $('#divLoading').css('display', 'none');
        },
        error: function(xhr, status){
            $('#txtErrorText').html(xhr.status + ': ' + xhr.statusText );
            $('#divErrorUpload').css('display', 'inline');
            console.log(xhr);

            $('#tblFileToUpload tbody').empty();
            $('#tblFileToUpload tbody').append(
                '<tr>' +
                    '<td>...</td>' +
                    '<td>...</td>' +
                    '<td>...</td>' +
                    '<td>...</td>' +
                    '<td>...</td>' +
                    '</tr>');

            $('#txtFileName').val('');

            err = true;

            $('#divLoading').css('display', 'none');
        },

        clearForm: false
    });


    var Upload = {
        get_list: function(cb){
            $.ajax({
                url: _base_url + 'uploads/get_uploaded_list',
                type: 'POST',
                dataType: 'json',

                success: function(data){
                    if(data.success){
                        cb(null, data.rows);
                    }else{
                        cb(data.msg);
                    }
                },

                error: function(xhr, status){
                    cb(xhr);
                }
            });
        }
    };

    $('#lnkTabCheck').click(function(){
        Upload.get_list(function(err, data){
            $('#tblUploadFileList tbody').empty();
            if(err){
                alert(err);
            }else{
                var i = 0;
                _.each(data, function(v){
                    i++;
                    var d = new Date(parseInt(v.uploaded_date.sec) * 1000 );
                    var year = parseInt(d.getFullYear())+ 543;
                    var month =  parseInt(d.getMonth()) + 1;
                    var date = d.getDate() - 10;


                    var new_date = date  + '/' + month + '/' + year;
                    $('#tblUploadFileList tbody').append(
                        '<tr>' +
                        '    <td>' + i + '</td> ' +
                        '    <td>' + v.file_name + '</td> ' +
                        '    <td>' + new_date + '</td> ' +
                        '    <td>' + v.email + '</td> ' +
                        '    <td><button id="btnImport" data-file="' + v.file_name + '" rel="tooltip" title="ประมวลผล" type="button" class="btn btn-info"><i class="icon-share"></i></button></td> ' +
                        '</tr> '
                    );
                });
            }
        });
    });

    $('#btnImport').tooltip();
});