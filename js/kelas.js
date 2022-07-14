getkelas(1);
function getkelas(start){
    $('#start').val(start);
    var search = $('#q').val();
    var limit = $('#limit').val();
    var url = base_url+'admin/kelas/datakelas?keyword=' + search + "&start=" + start + "&limit=" + limit;
    $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        beforeSend: function () {
            var tabel = "<tr id='loading'><td colspan='6'><b>Loading...</b></td></tr>";
            $('#datakelas').html(tabel);
            $('#pagination').html('');
        },
        success : function(data){
            //menghitung jumlah data
            
            if(data["status"]==true){
                $('#datakelas').html('');
                var res    = data["data"];
                var jmlData=res.length;
                var limit   = data["limit"];
                var tabel   = "";
                //Create Tabel
                var no = (parseInt(start)*parseInt(limit))-parseInt(limit);
                var dari = no+1;
                var sampai = no+parseInt(limit);
                var desc = "<button class='btn btn-default btn-sm' type='button'>Showing "+ dari + " To " + sampai + " of " +data["row_count"]+"</button>";
                for(var i=0; i<jmlData;i++){
                    no++;
                    tabel="<tr>";tabel+="<td>"+no+"</td>";
                    tabel+="<td>"+res[i]['kelasnama']+"</td>";
                    tabel+="<td>"+res[i]['kelasta']+"</td>";
                    tabel+="<td>"+res[i]['semnama']+"</td>";
                    if(res[i]['kelasstatus']==1) tabel+="<td><span class='btn btn-success btn-xs'>Aktif</span></td>";
                    else tabel+="<td><span class='btn btn-danger btn-xs'>Non Aktif</span></td>";
                    tabel+="<td><div class='btn-group'>"+
                    "<button onclick='addSiswa(\""+res[i]["kelasid"]+"\")' class='btn btn-info btn-xs'><span class='fa fa-users'></span> Tambahkan Siswa</button>"+
                    "<button onclick='addMpl(\""+res[i]["kelasid"]+"\")' class='btn btn-primary btn-xs'><span class='fa fa-file-o'></span> Tambahkan Mata pelajaran</button>"+
                    "<a href='"+base_url+'admin/kelas/nilai/'+res[i]['kelasid']+"' target='_blank' class='btn btn-success btn-xs'><span class='fa fa-search'></span> Nilai</a>"+
                    "<a href='#' class='btn btn-warning btn-xs'  onclick='edit(\""+res[i]["kelasid"]+"\")'><span class='fa fa-pencil'></span> Edit</a>"+
                    "<button onclick='hapus(\""+res[i]["kelasid"]+"\")' class='btn btn-danger btn-xs'><span class='fa fa-trash'></span> Hapus</button>"+
                    "</div></td>";tabel+="</tr>";
                    $('#datakelas').append(tabel);
                }
                //Create Pagination
                if(data["row_count"]<=limit){
                    $('#pagination').html("");
                }else{
                    console.log("buat Pagination");
                    var pagination="";
                    var btnkelasid="";
                    jmlPage = Math.ceil(data["row_count"]/limit);
                    offset  = data["start"] % limit;
                    var curkelasid = start;
                    var btn="btn-default";
                    var btnFirst="<button class='btn btn-default btn-sm' onclick='getkelas(1)'><span class='fa fa-angle-double-left'></span></button>";
                    if (curkelasid > 1) {
                        var prevSt=curkelasid-1;
                        btnFirst+="<button class='btn btn-default btn-sm' onclick='getkelas("+prevSt+")'><span class='fa fa-angle-left'></span></button>";
                    }
        
                    var btnLast="";
                    if(curkelasid<jmlPage){
                        var nextSt=curkelasid+1;
                        btnLast+="<button class='btn btn-default btn-sm' onclick='getkelas("+nextSt+")'><span class='fa fa-angle-right'></span></button>";
                    }
                    console.log(curkelasid);
                    btnLast+="<button class='btn btn-default btn-sm' onclick='getkelas("+jmlPage+")'><span class='fa fa-angle-double-right'></span></button>";
                    
                    if(jmlPage>=5){
                        console.clear();
                        console.log('Jumlah Halaman > 5');
                        if(curkelasid>=3){
                            console.log('Cur kelasid >= 3');
                            var kelasid_start=curkelasid - 2;
                            var kelasid_end=curkelasid + 2;
                            if(kelasid_end>=jmlPage) kelasid_end=jmlPage;
                        }else{
                            var kelasid_start=1;
                            var kelasid_end=5;
                        }
                        for (var j = kelasid_start; j<=kelasid_end; j++) {
                            if(curkelasid==j)  btn="btn-success"; else btn= "btn-default";
                            btnkelasid+="<button class='btn " +btn +" btn-sm' onclick='getkelas("+ j +")'>" + j +"</button>";
                        }
                    }else{
        
                        for (var j = 1; j<=jmlPage; j++) {
                            if(curkelasid==j)  btn="btn-success"; else btn= "btn-default";
                            btnkelasid+="<button class='btn " +btn +" btn-sm' onclick='getkelas("+ j +")'>" + j +"</button>";
                        }
                    }
                    pagination+="<div class='btn-group'>"+desc+btnFirst + btnkelasid + btnLast+"</div>";
                    $('#pagination').html(pagination);
                }
            }
        },
        complete : function(){
            //$('#loading').hide();
        }
    });
}
function tambah(){
    $('#modal').modal('show');
    resetForm();
}
function resetForm(){
    $('#kelasid').val("");
    $('#kelasid').prop('readonly',false);
    $('#kelasnama').val("");
    $('#kelasta').val("");
    $('#kelassemid').val("");
    $('#kelasstatus').prop('checked',false);
}
function simpan(){
    var url;
    url = base_url + "admin/kelas/insert";
    var formData = new FormData($('#form')[0]);
    $.ajax({
        url : url,
        type: "POST",
        data : formData,
        processData: false,
        contentType: false,
        dataType: 'JSON',
        beforeSend: function() {
            // setting a timeout
            $('#btnsimpan').prop("disabled",true);
            $('#iconsimpan').removeClass('fa fa-save')
            $('#iconsimpan').addClass('fa fa-spinner spin')
            // $(placeholder).addClass('loading');
        },
        success: function(data)
        {
            if(data.status==true){
                getkelas(1)
                tampilkanPesan('warning',data.message);
                $('#modal').modal('hide');
            }
            else{
                swal({
                    title: "Peringatan",
                    text: data.message,
                    type: "warning",
                    timer: 5000
                });
            }
            
        },
        error: function(xhr) { // if error occured
            tampilkanPesan('error',xhr.statusText+' - '+xhr.responseText)
            $('#btnsimpan').prop("disabled",false);
            $('#iconsimpan').removeClass('fa fa-spinner spin')
            $('#iconsimpan').addClass('fa fa-save')
        },
        complete: function() {
            $('#btnsimpan').prop("disabled",false);
            $('#iconsimpan').removeClass('fa fa-spinner spin')
            $('#iconsimpan').addClass('fa fa-save')
        }
    });
}
function hapus(id) {
    var isConfirm = confirm("Apakah anda yakin akan menghapus")
    if (isConfirm) {
        $.ajax({
            url: base_url + "admin/kelas/hapus/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                if(data.status==true){
                    tampilkanPesan('success',data.message)
                    getkelas(1);
                }else{
                    tampilkanPesan('error',data.message)
                }
                
            },
            error: function (jqXHR, textkelas, errorThrown) {
                alert('Error')
            }
        });
    }
}
function edit(id) {
    $.ajax({
        url: base_url + "admin/kelas/edit/" + id,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            // var start=$('#start').val();
            // getkelas(1);
            if(data.status==true){
                $('#modal').modal('show');
                $('#kelasid').val(data.data.kelasid)
                $('#kelasid').prop('readonly',true);
                $('#kelasnama').val(data.data.kelasnama)
                $('#kelasta').val(data.data.kelasta)
                $('#kelassemid').val(data.data.kelassemid)
                if(data.data.kelasstatus==1) $('#kelasstatus').prop('checked',true);
                else  $('#kelasstatus').prop('checked',false)
            }else{
                tampilkanPesan('danger',data.message);
            }
        },
        error: function (jqXHR, textkelas, errorThrown) {
            alert('Error')
        }
    });
}
function addSiswa(kelasid){
    $.ajax({
        url: base_url + "admin/kelas/addsiswa/" + kelasid,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            if(data.status==true){
                $('#siswa').modal('show')
                $('#kskelasid').val(kelasid)
                $('.namakelas').html(data.data.kelasnama);
                var siswa=data.siswalain;
                var tabelsiswa="";
                for (let i = 0; i < siswa.length; i++) {
                    const row = siswa[i];
                    tabelsiswa+='<tr>'+
                        '<td><input type="checkbox" name="nis[]" id="nis'+row.nis+'" class="nis" value="'+row.nis+'"></td>'+
                        '<td>'+row.siswanama+'</td>'+
                    '</tr>'
                }
                $('#datasiswa').html(tabelsiswa)
                var siswapilih=data.siswa;
                var tabelsiswapilih="";
                for (let j = 0; j < siswapilih.length; j++) {
                    const res = siswapilih[j];
                    tabelsiswapilih+='<tr>'+
                        '<td>'+res.nis+'</td>'+
                        '<td>'+res.siswanama+'</td>'+
                        '<td><button type="button" class="btn btn-danger btn-xs" onclick="hapusPilihanSiswa(\''+res.ksid+'\')">Hapus</button></td>'+
                    '</tr>'
                }
                $('#datasiswapilih').html(tabelsiswapilih)
            }else{
                tampilkanPesan('danger',data.message);
            }
        },
        error: function (jqXHR, textkelas, errorThrown) {
            alert('Error')
        }
    });
}
function checkallSiswa(){
    var pilih = $('#checkallsiswa').prop("checked");
    $('.nis').prop("checked",pilih);
}

function simpanSiswa(){
    var url;
    url = base_url + "admin/kelas/insertsiswa";
    var formData = new FormData($('#formsiswa')[0]);
    $.ajax({
        url : url,
        type: "POST",
        data : formData,
        processData: false,
        contentType: false,
        dataType: 'JSON',
        beforeSend: function() {
            // setting a timeout
            $('#btnsimpansiswa').prop("disabled",true);
            $('#iconsimpansiswa').removeClass('fa fa-save')
            $('#iconsimpansiswa').addClass('fa fa-spinner spin')
            // $(placeholder).addClass('loading');
        },
        success: function(data)
        {
            if(data.status==true){
                var kelas=$('#kskelasid').val();
                addSiswa(kelas);
                tampilkanPesan('warning',data.message);
                // $('#siswa').modal('hide');
            }
            else{
                swal({
                    title: "Peringatan",
                    text: data.message,
                    type: "warning",
                    timer: 5000
                });
            }
            
        },
        error: function(xhr) { // if error occured
            tampilkanPesan('error',xhr.statusText+' - '+xhr.responseText)
            $('#btnsimpansiswa').prop("disabled",false);
            $('#iconsimpansiswa').removeClass('fa fa-spinner spin')
            $('#iconsimpansiswa').addClass('fa fa-save')
        },
        complete: function() {
            $('#btnsimpansiswa').prop("disabled",false);
            $('#iconsimpansiswa').removeClass('fa fa-spinner spin')
            $('#iconsimpansiswa').addClass('fa fa-save')
        }
    });
}

function hapusPilihanSiswa(id){
    var isConfirm = confirm("Apakah anda yakin akan menghapus data ini")
    if (isConfirm) {
        $.ajax({
            url: base_url + "admin/kelas/hapuspilihansiswa/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                if(data.status==true){
                    tampilkanPesan('success',data.message)
                    var kelas=$('#kskelasid').val();
                    addSiswa(kelas);
                }else{
                    tampilkanPesan('error',data.message)
                }
                
            },
            error: function (jqXHR, textkelas, errorThrown) {
                alert('Error')
            }
        });
    }
}

function addMpl(kelasid) {
    $.ajax({
        url: base_url + "admin/kelas/addmpl/" + kelasid,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            if(data.status==true){
                $('#mapel').modal('show')
                $('#kmkelasid').val(kelasid)
                $('.namakelas').html(data.data.kelasnama);
                var mapel=data.mapellain;
                var tabelmapel="";
                for (let i = 0; i < mapel.length; i++) {
                    const row = mapel[i];
                    tabelmapel+='<tr>'+
                        '<td><input type="checkbox" name="mapelid[]" id="mapelid'+row.mapelid+'" class="mapelid" value="'+row.mapelid+'"></td>'+
                        '<td>'+row.mapelnama+'</td>'+
                    '</tr>'
                }
                $('#datamapel').html(tabelmapel)
                var mapelpilih=data.mapel;
                var tabelmapelpilih="";
                for (let j = 0; j < mapelpilih.length; j++) {
                    const res = mapelpilih[j];
                    tabelmapelpilih+='<tr>'+
                        '<td>'+res.mapelnama+'</td>'+
                        '<td><button type="button" class="btn btn-danger btn-xs" onclick="hapusPilihanMapel(\''+res.kmid+'\')">Hapus</button></td>'+
                    '</tr>'
                }
                $('#datamapelpilih').html(tabelmapelpilih)
            }else{
                tampilkanPesan('danger',data.message);
            }
        },
        error: function (jqXHR, textkelas, errorThrown) {
            alert('Error')
        }
    });
}

function checkallMapel(){
    var pilih = $('#checkallmapel').prop("checked");
    $('.mapelid').prop("checked",pilih);
}

function simpanMapel(){
    var url;
    url = base_url + "admin/kelas/insertmapel";
    var formData = new FormData($('#formmapel')[0]);
    $.ajax({
        url : url,
        type: "POST",
        data : formData,
        processData: false,
        contentType: false,
        dataType: 'JSON',
        beforeSend: function() {
            // setting a timeout
            $('#btnsimpanmapel').prop("disabled",true);
            $('#iconsimpanmapel').removeClass('fa fa-save')
            $('#iconsimpanmapel').addClass('fa fa-spinner spin')
            // $(placeholder).addClass('loading');
        },
        success: function(data)
        {
            if(data.status==true){
                var kelas=$('#kmkelasid').val();
                addMpl(kelas);
                tampilkanPesan('warning',data.message);
                // $('#mapel').modal('hide');
            }
            else{
                swal({
                    title: "Peringatan",
                    text: data.message,
                    type: "warning",
                    timer: 5000
                });
            }
            
        },
        error: function(xhr) { // if error occured
            tampilkanPesan('error',xhr.statusText+' - '+xhr.responseText)
            $('#btnsimpanmapel').prop("disabled",false);
            $('#iconsimpanmapel').removeClass('fa fa-spinner spin')
            $('#iconsimpanmapel').addClass('fa fa-save')
        },
        complete: function() {
            $('#btnsimpanmapel').prop("disabled",false);
            $('#iconsimpanmapel').removeClass('fa fa-spinner spin')
            $('#iconsimpanmapel').addClass('fa fa-save')
        }
    });
}

function hapusPilihanMapel(id){
    var isConfirm = confirm("Apakah anda yakin akan menghapus data ini")
    if (isConfirm) {
        $.ajax({
            url: base_url + "admin/kelas/hapuspilihanmapel/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                if(data.status==true){
                    tampilkanPesan('success',data.message)
                    var kelas=$('#kmkelasid').val();
                    addMpl(kelas);
                }else{
                    tampilkanPesan('error',data.message)
                }
                
            },
            error: function (jqXHR, textkelas, errorThrown) {
                alert('Error')
            }
        });
    }
}
function pilihMapel(mapelid,mapelnama=""){
    $('#nilaimapelid').val(mapelid);
    if(mapelnama!="") $('.mapelnama').html(mapelnama);
    $('.mapel').removeClass('active');
    $('#li'+mapelid).addClass('active');
    var kelasid=$('#nilaikelasid').val();
    $.ajax({
        url: base_url + "admin/kelas/listnilai/" + kelasid+"/"+mapelid,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            if(data.status==true){
                var nilai=data.data;
                var tabelnilai="";
                var no=0;
                var nilaiangka='';
                var nilaiid='';
                var sudahdinilai=0;
                for (let i = 0; i < nilai.length; i++) {
                    const row = nilai[i];
                    no++;
                    if(row.nilaiangka==null) nilaiangka=''; else nilaiangka=row.nilaiangka;
                    if(row.nilaiid==null) nilaiid=''; else {
                        nilaiid=row.nilaiid;
                        sudahdinilai++;
                    }
                    tabelnilai+='<tr>'+
                        '<td>'+no+'</td>'+
                        '<td>'+row.siswanama+'</td>'+
                        '<td>'+
                        '<input type="hidden" name="nilaiid'+row.ksnis+'" id="nilaiid'+row.ksnis+'" value="'+nilaiid+'">'+
                        '<input type="hidden" name="nis[]" id="nis'+row.ksnis+'" value="'+row.ksnis+'">'+
                        '<input type="text" class="form-control nilai" id="nilai'+row.ksnis+'" name="nilai'+row.ksnis+'" value="'+nilaiangka+'">'+
                        '</td>'+
                    '</tr>'
                }
                $('#datanilai').html(tabelnilai)
                if(sudahdinilai>0){
                    var tombol='<a href="'+base_url+'admin/kelas/rekapnilai/'+kelasid+'/'+mapelid+'" target="_blank" class="btn btn-default" ><span class="fa fa-print"></span>Cetak Rekap Nilai</a>'+
                    '<button class="btn btn-danger" type="button" onclick="simpanNilai()" id="simpannilai"><span id="iconsimpannilai" class="fa fa-save"></span>Simpan Nilai</button>';
                }else{
                    var tombol='<button class="btn btn-danger" type="button" onclick="simpanNilai()" id="simpannilai"><span id="iconsimpannilai" class="fa fa-save"></span>Simpan Nilai</button>';
                }
                $('#tombol').html(tombol);
            }else{
                tampilkanPesan('danger',data.message);
            }
        },
        error: function (jqXHR, textkelas, errorThrown) {
            alert('Error')
        }
    });
}
function simpanNilai(){
    var mapelid=$('#nilaimapelid').val();
    if(mapelid==""){
        tampilkanPesan('warning','Pilih Matapelajaran terlebih Dahulu');
        return false;
    }
    var url;
    url = base_url + "admin/kelas/insertnilai";
    var formData = new FormData($('#formnilai')[0]);
    $.ajax({
        url : url,
        type: "POST",
        data : formData,
        processData: false,
        contentType: false,
        dataType: 'JSON',
        beforeSend: function() {
            // setting a timeout
            $('#btnsimpannilai').prop("disabled",true);
            $('#iconsimpannilai').removeClass('fa fa-save')
            $('#iconsimpannilai').addClass('fa fa-spinner spin')
            // $(placeholder).addClass('loading');
        },
        success: function(data)
        {
            if(data.status==true){
                var mapelid = $('#nilaimapelid').val();
                pilihMapel(mapelid);
                tampilkanPesan('warning',data.message);
                // $('#mapel').modal('hide');
            }
            else{
                swal({
                    title: "Peringatan",
                    text: data.message,
                    type: "warning",
                    timer: 5000
                });
            }
            
        },
        error: function(xhr) { // if error occured
            tampilkanPesan('error',xhr.statusText+' - '+xhr.responseText)
            $('#btnsimpannilai').prop("disabled",false);
            $('#iconsimpannilai').removeClass('fa fa-spinner spin')
            $('#iconsimpannilai').addClass('fa fa-save')
        },
        complete: function() {
            $('#btnsimpannilai').prop("disabled",false);
            $('#iconsimpannilai').removeClass('fa fa-spinner spin')
            $('#iconsimpannilai').addClass('fa fa-save')
        }
    });
}