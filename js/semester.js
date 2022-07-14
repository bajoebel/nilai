getsemester(1);
function getsemester(start){
    $('#start').val(start);
    var search = $('#q').val();
    var limit = $('#limit').val();
    var url = base_url+'admin/semester/datasemester?keyword=' + search + "&start=" + start + "&limit=" + limit;
    $.ajax({
        url     : url,
        type    : "GET",
        dataType: "json",
        data    : {get_param : 'value'},
        beforeSend: function () {
            var tabel = "<tr id='loading'><td colspan='6'><b>Loading...</b></td></tr>";
            $('#datasemester').html(tabel);
            $('#pagination').html('');
        },
        success : function(data){
            //menghitung jumlah data
            
            if(data["status"]==true){
                $('#datasemester').html('');
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
                    tabel+="<td>"+res[i]['semnama']+"</td>";
                    if(res[i]['semstatus']==1) tabel+="<td><span class='btn btn-success btn-xs'>Aktif</span></td>";
                    else tabel+="<td><span class='btn btn-danger btn-xs'>Non Aktif</span></td>";
                    tabel+="<td><div class='btn-group'><a href='#' class='btn btn-warning btn-xs'  onclick='edit(\""+res[i]["semid"]+"\")'><span class='fa fa-pencil'></span> Edit</a><button onclick='hapus(\""+res[i]["semid"]+"\")' class='btn btn-danger btn-xs'><span class='fa fa-trash'></span> Hapus</button></div></td>";tabel+="</tr>";
                    $('#datasemester').append(tabel);
                }
                //Create Pagination
                if(data["row_count"]<=limit){
                    $('#pagination').html("");
                }else{
                    console.log("buat Pagination");
                    var pagination="";
                    var btnsemid="";
                    jmlPage = Math.ceil(data["row_count"]/limit);
                    offset  = data["start"] % limit;
                    var cursemid = start;
                    var btn="btn-default";
                    var btnFirst="<button class='btn btn-default btn-sm' onclick='getsemester(1)'><span class='fa fa-angle-double-left'></span></button>";
                    if (cursemid > 1) {
                        var prevSt=cursemid-1;
                        btnFirst+="<button class='btn btn-default btn-sm' onclick='getsemester("+prevSt+")'><span class='fa fa-angle-left'></span></button>";
                    }
        
                    var btnLast="";
                    if(cursemid<jmlPage){
                        var nextSt=cursemid+1;
                        btnLast+="<button class='btn btn-default btn-sm' onclick='getsemester("+nextSt+")'><span class='fa fa-angle-right'></span></button>";
                    }
                    console.log(cursemid);
                    btnLast+="<button class='btn btn-default btn-sm' onclick='getsemester("+jmlPage+")'><span class='fa fa-angle-double-right'></span></button>";
                    
                    if(jmlPage>=5){
                        console.clear();
                        console.log('Jumlah Halaman > 5');
                        if(cursemid>=3){
                            console.log('Cur semid >= 3');
                            var semid_start=cursemid - 2;
                            var semid_end=cursemid + 2;
                            if(semid_end>=jmlPage) semid_end=jmlPage;
                        }else{
                            var semid_start=1;
                            var semid_end=5;
                        }
                        for (var j = semid_start; j<=semid_end; j++) {
                            if(cursemid==j)  btn="btn-success"; else btn= "btn-default";
                            btnsemid+="<button class='btn " +btn +" btn-sm' onclick='getsemester("+ j +")'>" + j +"</button>";
                        }
                    }else{
        
                        for (var j = 1; j<=jmlPage; j++) {
                            if(cursemid==j)  btn="btn-success"; else btn= "btn-default";
                            btnsemid+="<button class='btn " +btn +" btn-sm' onclick='getsemester("+ j +")'>" + j +"</button>";
                        }
                    }
                    pagination+="<div class='btn-group'>"+desc+btnFirst + btnsemid + btnLast+"</div>";
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
    $('#semid').val("");
    $('#semid').prop('readonly',false);
    $('#semnama').val("");
    $('#semstatus').prop('checked',false);
}
function simpan(){
    var url;
    url = base_url + "admin/semester/insert";
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
                getsemester(1)
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
            url: base_url + "admin/semester/hapus/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                if(data.status==true){
                    tampilkanPesan('success',data.message)
                    getsemester(1);
                }else{
                    tampilkanPesan('error',data.message)
                }
                
            },
            error: function (jqXHR, textsemester, errorThrown) {
                alert('Error')
            }
        });
    }
}
function edit(id) {
    $.ajax({
        url: base_url + "admin/semester/edit/" + id,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            // var start=$('#start').val();
            // getsemester(1);
            if(data.status==true){
                $('#modal').modal('show');
                $('#semid').val(data.data.semid)
                $('#semid').prop('readonly',true);
                $('#semnama').val(data.data.semnama)
                if(data.data.semstatus==1) $('#semstatus').prop('checked',true);
                else  $('#semstatus').prop('checked',false)
            }else{
                tampilkanPesan('danger',data.message);
            }
        },
        error: function (jqXHR, textsemester, errorThrown) {
            alert('Error')
        }
    });
}

