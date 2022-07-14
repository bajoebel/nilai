getsiswa(1);
function getsiswa(start){
    $('#start').val(start);
    var search = $('#q').val();
    var limit = $('#limit').val();
    var url = base_url+'admin/siswa/datasiswa?keyword=' + search + "&start=" + start + "&limit=" + limit;
    $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        beforeSend: function () {
            var tabel = "<tr id='loading'><td colspan='6'><b>Loading...</b></td></tr>";
            $('#datasiswa').html(tabel);
            $('#pagination').html('');
        },
        success : function(data){
            //menghitung jumlah data
            
            if(data["status"]==true){
                $('#datasiswa').html('');
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
                    tabel+="<td>"+res[i]['nis']+"</td>";
                    tabel+="<td>"+res[i]['siswanama']+"</td>";
                    tabel+="<td>"+res[i]['siswajekel']+"</td>";
                    tabel+="<td>"+res[i]['siswatmplahir']+"</td>";
                    tabel+="<td>"+res[i]['siswatgllahir']+"</td>";
                    if(res[i]['siswastatus']==1) tabel+="<td><span class='btn btn-success btn-xs'>Aktif</span></td>";
                    else tabel+="<td><span class='btn btn-danger btn-xs'>Non Aktif</span></td>";
                    tabel+="<td><div class='btn-group'><a href='#' class='btn btn-warning btn-xs'  onclick='edit(\""+res[i]["nis"]+"\")'><span class='fa fa-pencil'></span> Edit</a><button onclick='hapus(\""+res[i]["nis"]+"\")' class='btn btn-danger btn-xs'><span class='fa fa-trash'></span> Hapus</button></div></td>";tabel+="</tr>";
                    $('#datasiswa').append(tabel);
                }
                //Create Pagination
                if(data["row_count"]<=limit){
                    $('#pagination').html("");
                }else{
                    console.log("buat Pagination");
                    var pagination="";
                    var btnnis="";
                    jmlPage = Math.ceil(data["row_count"]/limit);
                    offset  = data["start"] % limit;
                    var curnis = start;
                    var btn="btn-default";
                    var btnFirst="<button class='btn btn-default btn-sm' onclick='getsiswa(1)'><span class='fa fa-angle-double-left'></span></button>";
                    if (curnis > 1) {
                        var prevSt=curnis-1;
                        btnFirst+="<button class='btn btn-default btn-sm' onclick='getsiswa("+prevSt+")'><span class='fa fa-angle-left'></span></button>";
                    }
        
                    var btnLast="";
                    if(curnis<jmlPage){
                        var nextSt=curnis+1;
                        btnLast+="<button class='btn btn-default btn-sm' onclick='getsiswa("+nextSt+")'><span class='fa fa-angle-right'></span></button>";
                    }
                    console.log(curnis);
                    btnLast+="<button class='btn btn-default btn-sm' onclick='getsiswa("+jmlPage+")'><span class='fa fa-angle-double-right'></span></button>";
                    
                    if(jmlPage>=5){
                        console.clear();
                        console.log('Jumlah Halaman > 5');
                        if(curnis>=3){
                            console.log('Cur nis >= 3');
                            var nis_start=curnis - 2;
                            var nis_end=curnis + 2;
                            if(nis_end>=jmlPage) nis_end=jmlPage;
                        }else{
                            var nis_start=1;
                            var nis_end=5;
                        }
                        for (var j = nis_start; j<=nis_end; j++) {
                            if(curnis==j)  btn="btn-success"; else btn= "btn-default";
                            btnnis+="<button class='btn " +btn +" btn-sm' onclick='getsiswa("+ j +")'>" + j +"</button>";
                        }
                    }else{
        
                        for (var j = 1; j<=jmlPage; j++) {
                            if(curnis==j)  btn="btn-success"; else btn= "btn-default";
                            btnnis+="<button class='btn " +btn +" btn-sm' onclick='getsiswa("+ j +")'>" + j +"</button>";
                        }
                    }
                    pagination+="<div class='btn-group'>"+desc+btnFirst + btnnis + btnLast+"</div>";
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
    $('#nis').val("");
    $('#nis').prop('readonly',false);
    $('#siswanama').val("");
    $('#siswajekel').val("");
    $('#siswatmplahir').val("");
    $('#siswatgllahir').val("");
    $('#siswastatus').prop('checked',false);
}
function simpan(){
    var url;
    url = base_url + "admin/siswa/insert";
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
                getsiswa(1)
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
            url: base_url + "admin/siswa/hapus/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                if(data.status==true){
                    tampilkanPesan('success',data.message)
                    getsiswa(1);
                }else{
                    tampilkanPesan('error',data.message)
                }
                
            },
            error: function (jqXHR, textsiswa, errorThrown) {
                alert('Error')
            }
        });
    }
}
function edit(id) {
    $.ajax({
        url: base_url + "admin/siswa/edit/" + id,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            // var start=$('#start').val();
            // getsiswa(1);
            if(data.status==true){
                $('#modal').modal('show');
                $('#nis').val(data.data.nis)
                $('#nis').prop('readonly',true);
                $('#siswanama').val(data.data.siswanama)
                $('#siswajekel').val(data.data.siswajekel)
                $('#siswatmplahir').val(data.data.siswatmplahir)
                $('#siswatgllahir').val(data.data.siswatgllahir)
                if(data.data.siswastatus==1) $('#siswastatus').prop('checked',true);
                else  $('#siswastatus').prop('checked',false)
            }else{
                tampilkanPesan('danger',data.message);
            }
        },
        error: function (jqXHR, textsiswa, errorThrown) {
            alert('Error')
        }
    });
}

