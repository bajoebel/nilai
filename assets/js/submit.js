$(document).ready(function () { 
    getTable();
    $('#btnTambah').click(function(){
        $('#submit').html('Simpan');
        $('#idx').val('');
        $('#kelas_layanan').val('');
        $('#formModal').modal('show');
    });
    $('#table_search').keypress(function(ev){
        var keycode = (ev.keyCode ? ev.keyCode : ev.which);
        if (keycode == '13') {
            $.ajax({
                url         : "<?php echo base_url().'administrator.php/kelas_layanan/getView' ?>",
                type        : "POST",
                data        : {sLike:$(this).val()},
                beforeSend  : function(){
                    $('tbody#getdata').html("<tr><td colspan=2>Loading... Please wait</td></tr>");
                },
                success : function(data){
                    $('tbody#getdata').html(data);
                },
                error : function(jqXHR,ajaxOption,errorThrown){
                    alert(errorThrown);
                }
            });            
        }
    });
    $('#btn_table_search').click(function(){
        $.ajax({
            url         : "<?php echo base_url().'administrator.php/kelas_layanan/getView' ?>",
            type        : "POST",
            data        : {sLike:$('#table_search').val()},
            beforeSend  : function(){
                $('tbody#getdata').html("<tr><td colspan=2>Loading... Please wait</td></tr>");
            },
            success : function(data){
                $('tbody#getdata').html(data);
            },
            error : function(jqXHR,ajaxOption,errorThrown){
                alert(errorThrown);
            }
        });            
    });
    
});

// Function
function getTable(){
    $.ajax({
        url : "<?php echo base_url().'administrator.php/kelas_layanan/getView' ?>",
        beforeSend  : function(){
            $('tbody#getdata').html("<tr><td colspan=2>Loading... Please wait</td></tr>");
        },
        success : function(data){
            $('tbody#getdata').html(data);
        },
        error : function(jqXHR,ajaxOption,errorThrown){
            alert(errorThrown);
        }
    });            
}
function edit(a,b){
    $('#submit').html('Update');
    $('#idx').val(a);
    $('#kelas_layanan').val(b);
    $('#formModal').modal("show");
}
function hapus(a){
    var x = confirm("Apakah anda yakin akan menghapus record ini?");
    if(x){
        $.ajax({
            url         : "<?php echo base_url().'administrator.php/kelas_layanan/hapus' ?>",
            type        : "POST",
            data        : {idx:a},
            dataType    : "JSON",
            success     : function(data){
                alert(data.message);    
                if(data.code==200){
                    getTable();
                }
            },
            error       : function(jqXHR,ajaxOption,errorThrown){
                console.log(jqXHR.responseText);                    
                alert(jqXHR.responseText);
            }
        });
    }
}
function simpan(){
    var a = $('#kelas_layanan').val();
    if(a==""){
        alert('Ops. kelas layanan harus di isi.');
    }else{
        $.ajax({
            url         : "<?php echo base_url().'administrator.php/kelas_layanan/simpan' ?>",
            type        : "POST",
            data        : $('#form1').serialize(),
            dataType    : "JSON",
            success     : function(data){
                if(data.code==200){
                    alert(data.message);
                    $('#form1').find('input').val('');
                }else if(data.code==201){
                    alert(data.message);
                    $('#form1').find('input').val('');
                    $('#formModal').modal('hide');
                }else{
                    alert(data.message);
                }
                getTable();
            },
            error       : function(jqXHR,ajaxOption,errorThrown){
                console.log(jqXHR.responseText);                    
                alert(jqXHR.responseText);
            }
        });
    }
}      