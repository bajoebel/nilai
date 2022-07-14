$(function () {        
    getdate();
    function getdate() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        if (h < 10) {
            h = "0" + h;
        }
        if (m < 10) {
            m = "0" + m;
        }
        if (s < 10) {
            s = "0" + s;
        }

        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agus', 'Sep', 'Okt', 'Nov', 'Des'];
        var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];
        var date = new Date();
        var day = date.getDate();
        var month = date.getMonth();
        var thisDay = date.getDay(),
            thisDay = myDays[thisDay];
        var yy = date.getYear();
        var year = (yy < 1000) ? yy + 1900 : yy;

        var tgl = ("&nbsp;" + thisDay + ', ' + day + ' ' + months[month] + ' ' + year);
        var jam = (h + ":" + m + ":" + s + " WIB");
        $("#timer").html(tgl + ' ' + jam);
        setTimeout(function () { getdate() }, 1000);
    }
    
    
});

function getLokasi(){
    var url = base_url + "dashboard/lokasi/";
    console.log(url);
    $.ajax({
        url : url,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            var html_lokasi = "";
            var lokasi = data.lokasi;
            var jmlData=lokasi.length;
            var lokasi_aktif = data.lokasi_aktif;
            console.log(lokasi_aktif);
            if(lokasi_aktif!=null){
                $('#lokasi-pilihan').html(lokasi_aktif.NMLOKASI);
                //location.reload();
            }else{
                $('#lokasi-pilihan').html("Pilih Lokasi")
            }
            var html_shorcut = ""
            var j = 0;
            var bg = 'bg-green';
            for (var i = 0; i < jmlData; i++){
                j = i+1;
                if (j % 4 == 1) bg = 'bg-blue';
                else if (j % 4 == 2) bg = 'bg-yellow';
                else if (j % 4 == 3) bg = 'bg-maroon';
                else bg = 'bg-green';
                html_lokasi+="<li><a href='#' onclick='pilihLokasi(\""+lokasi[i].KDLOKASI+"\")'>"+lokasi[i].NMLOKASI+"</a></li>";
                //html_shorcut+='<a href="#" onclick="pilihLokasi(\''+lokasi[i].KDLOKASI+'\')" class="btn btn-app"><i class="fa fa-plus-square"></i> '+lokasi[i].NMLOKASI+'</a>';
                html_shorcut += '<div class="col-md-3 col-sm-6 col-xs-12">'+
                '<a href="#" onclick="pilihLokasi(\''+lokasi[i].KDLOKASI+'\')"><div class="info-box '+bg+'">'+
                  '<span class="info-box-icon"><i class="fa fa-plus-square"></i></span>'+
                       '<div class="info-box-content">'+
                    '<span class="info-box-text">'+lokasi[i].NMLOKASI+'</span>'+
                    '<span class="info-box-number"></span>'+
                    '<div class="progress">'+
                      '<div class="progress-bar" style="width: 100%"></div>'+
                    '</div>'+
                        '<span class="progress-description">'+
                          'Silahkan Pilih Ruangan Tempat Anda Log In'+
                       ' </span>'+
                  '</div>'+
               ' </div>'+
              '</div>';
            }
            $('#mode-lokasi').html(html_lokasi);
            if(jmlData==1) pilihLokasi(lokasi[0].KDLOKASI);
            if(lokasi_aktif==null) $('#shorcut-lokasi').html(html_shorcut);
            else $('#shorcut-lokasi').hide();
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            console.log("Error Lokasi : "+textStatus);
        }
    });
}

function pilihLokasi(kdlokasi){
    var url = base_url + "dashboard/pilih_lokasi/"+kdlokasi;
    console.log(url); 
    $.ajax({
        url : url,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            location.reload(); 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            console.log("Error Lokasi : "+textStatus);
        }
    });
}
function tampilkanPesan(a, b, c = "") {
    if (a == 'error') {
        swal({
            title: c,
            text: b,
            type: "error",
            confirmButtonColor: "#f00",
            confirmButtonText: "OK"
        });
    } else if (a == 'success') {
        swal({
            title: c,
            text: b,
            type: "success",
            confirmButtonColor: "#034a03",
            confirmButtonText: "OK"
        });
    } else if (a == 'warning') {
        swal({
            title: c,
            text: b,
            type: "warning",
            confirmButtonColor: "#034a03",
            confirmButtonText: "OK"
        });
    } else {
        alert(b);
    }
}
