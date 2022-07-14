getmapel(1);
function getmapel(start){
    $('#start').val(start);
    var search = $('#q').val();
    var limit = $('#limit').val();
    var url = base_url+'admin/mapel/datamapel?keyword=' + search + "&start=" + start + "&limit=" + limit;
    $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        beforeSend: function () {
            var tabel = "<tr id='loading'><td colspan='6'><b>Loading...</b></td></tr>";
            $('#datamapel').html(tabel);
            $('#pagination').html('');
        },
        success : function(data){
            //menghitung jumlah data
            
            if(data["status"]==true){
                $('#datamapel').html('');
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
                    tabel+="<td>"+res[i]['mapelnama']+"</td>";
                    tabel+="<td>"+res[i]['mapelkkm']+"</td>";
                    if(res[i]['mapelstatus']==1) tabel+="<td><span class='btn btn-success btn-xs'>Aktif</span></td>";
                    else tabel+="<td><span class='btn btn-danger btn-xs'>Non Aktif</span></td>";
                    tabel+="<td><div class='btn-group'><a href='#' class='btn btn-warning btn-xs'  onclick='edit(\""+res[i]["mapelid"]+"\")'><span class='fa fa-pencil'></span> Edit</a><button onclick='hapus(\""+res[i]["mapelid"]+"\")' class='btn btn-danger btn-xs'><span class='fa fa-trash'></span> Hapus</button></div></td>";tabel+="</tr>";
                    $('#datamapel').append(tabel);
                }
                //Create Pagination
                if(data["row_count"]<=limit){
                    $('#pagination').html("");
                }else{
                    console.log("buat Pagination");
                    var pagination="";
                    var btnmapelid="";
                    jmlPage = Math.ceil(data["row_count"]/limit);
                    offset  = data["start"] % limit;
                    var curmapelid = start;
                    var btn="btn-default";
                    var btnFirst="<button class='btn btn-default btn-sm' onclick='getmapel(1)'><span class='fa fa-angle-double-left'></span></button>";
                    if (curmapelid > 1) {
                        var prevSt=curmapelid-1;
                        btnFirst+="<button class='btn btn-default btn-sm' onclick='getmapel("+prevSt+")'><span class='fa fa-angle-left'></span></button>";
                    }
        
                    var btnLast="";
                    if(curmapelid<jmlPage){
                        var nextSt=curmapelid+1;
                        btnLast+="<button class='btn btn-default btn-sm' onclick='getmapel("+nextSt+")'><span class='fa fa-angle-right'></span></button>";
                    }
                    console.log(curmapelid);
                    btnLast+="<button class='btn btn-default btn-sm' onclick='getmapel("+jmlPage+")'><span class='fa fa-angle-double-right'></span></button>";
                    
                    if(jmlPage>=5){
                        console.clear();
                        console.log('Jumlah Halaman > 5');
                        if(curmapelid>=3){
                            console.log('Cur mapelid >= 3');
                            var mapelid_start=curmapelid - 2;
                            var mapelid_end=curmapelid + 2;
                            if(mapelid_end>=jmlPage) mapelid_end=jmlPage;
                        }else{
                            var mapelid_start=1;
                            var mapelid_end=5;
                        }
                        for (var j = mapelid_start; j<=mapelid_end; j++) {
                            if(curmapelid==j)  btn="btn-success"; else btn= "btn-default";
                            btnmapelid+="<button class='btn " +btn +" btn-sm' onclick='getmapel("+ j +")'>" + j +"</button>";
                        }
                    }else{
        
                        for (var j = 1; j<=jmlPage; j++) {
                            if(curmapelid==j)  btn="btn-success"; else btn= "btn-default";
                            btnmapelid+="<button class='btn " +btn +" btn-sm' onclick='getmapel("+ j +")'>" + j +"</button>";
                        }
                    }
                    pagination+="<div class='btn-group'>"+desc+btnFirst + btnmapelid + btnLast+"</div>";
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
    $('#mapelid').val("");
    $('#mapelid').prop('readonly',false);
    $('#mapelnama').val("");
    $('#mapelkkm').val("");
    $('#mapelstatus').prop('checked',false);
}
function simpan(){
    var url;
    url = base_url + "admin/mapel/insert";
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
                getmapel(1)
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
            url: base_url + "admin/mapel/hapus/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                if(data.status==true){
                    tampilkanPesan('success',data.message)
                    getmapel(1);
                }else{
                    tampilkanPesan('error',data.message)
                }
                
            },
            error: function (jqXHR, textmapel, errorThrown) {
                alert('Error')
            }
        });
    }
}
function edit(id) {
    $.ajax({
        url: base_url + "admin/mapel/edit/" + id,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            // var start=$('#start').val();
            // getmapel(1);
            if(data.status==true){
                $('#modal').modal('show');
                $('#mapelid').val(data.data.mapelid)
                $('#mapelid').prop('readonly',true);
                $('#mapelnama').val(data.data.mapelnama)
                $('#mapelkkm').val(data.data.mapelkkm)
                $('#mapeltmplahir').val(data.data.mapeltmplahir)
                $('#mapeltgllahir').val(data.data.mapeltgllahir)
                if(data.data.mapelstatus==1) $('#mapelstatus').prop('checked',true);
                else  $('#mapelstatus').prop('checked',false)
            }else{
                tampilkanPesan('danger',data.message);
            }
        },
        error: function (jqXHR, textmapel, errorThrown) {
            alert('Error')
        }
    });
}

