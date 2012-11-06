/**
 * Main application script
 */
var App = {
    showLoginLoading: function(){
        $('#divLoading').css('display', 'inline');
    },
    hideLoginLoading: function(){
        $('#divLoading').css('display', 'none');
    },
    showLoading: function(){
        $.blockUI({ css: {
            border: 'none',
            padding: '15px',
            backgroundColor: '#000',
            '-webkit-border-radius': '10px',
            '-moz-border-radius': '10px',
            opacity: .5,
            color: '#fff'
        } });
    },

    hideLoading: function(){
        $.unblockUI();
    },

    showImageLoading: function(){
        $('#imgLoading').css('display', 'inline');
    },

    hideImageLoading: function(){
        $('#imgLoading').css('display', 'none');
    },

    convertToThaiDateFormat: function(d){
        if(!d){
            return '-';
        }else{
            var old_date = d.toString();

            var year = old_date.substr(0, 4).toString(),
                month = old_date.substr(4, 2).toString(),
                day = old_date.substr(6, 2).toString();

            var new_date = day + '/' + month + '/' + year;

            return new_date;
        }

    },

    countAge: function(d){
        if(!d){
            return 0;
        }else{
            var old_date = d.toString();

            var year_birth = old_date.substr(0, 4);
            var year_current = new Date();
            var year_current2 = year_current.getFullYear() + 543;

            var age = year_current2 - parseInt(year_birth);

            return age;
        }
    },

    getFileExtension: function(filename)
    {
        var ext = /^.+\.([^.]+)$/.exec(filename);
        return ext == null ? "" : ext[1];
    },
    getReadableFileSizeString: function(fileSizeInBytes) {

        var i = -1;
        var byteUnits = [' kB', ' MB', ' GB', ' TB', 'PB', 'EB', 'ZB', 'YB'];
        do {
            fileSizeInBytes = fileSizeInBytes / 1024;
            i++;
        } while (fileSizeInBytes > 1024);

        return Math.max(fileSizeInBytes, 0.1).toFixed(1) + byteUnits[i];
    }
};