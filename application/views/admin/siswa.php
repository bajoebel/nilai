<section class="content-header">
    <h1><?php echo $contentTitle ?></h1>
</section>

<section class="content container-fluid">
    <div class="row">

        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><button class="btn btn-danger" onclick='tambah()'><span class="fa fa-plus"></span> Tambah</button></h3>
                    <div class="box-tools">
                        
                    </div>
                </div>
                <div class="box-body table-responsive">
                    <div class="row">
                        <div class="col-md-11">
                            <form action="#" method="GET" onsubmit="return false">
                                <div class="input-group">
                                    <input type="text" name="q" id="q" class="form-control pull-right" onkeydown="getsiswa(1)" placeholder="Search">
                                    <span class="input-group-addon">
                                        <span class="fa fa-search"></span>
                                    </span>
                                </div>
                                <input type="hidden" name="param" id="param">
                            </form>
                        </div>
                        <div class="col-md-1">
                            <div class="input-group">
                                <select class="form-control" name="limit" id="limit" onchange="getsiswa(1)">
                                    <option value="5">5</option>
                                    <option value="10" selected>10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-striped">
                                <thead class="bg-red">
                                    <tr>
                                        <th style="width: 40px">#</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Tempat Lahir</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Status</th>
                                        <th style="width: 150px; text-align:right;">#</th>
                                    </tr>
                                </thead>
                                <tbody id="datasiswa"></tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" id="pagination"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal -->
<div id="modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tambah siswa</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="form" action="#">
        <div class="form-group">
                <label class="control-label col-sm-2" for="email">NIS:</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="nis" name="nis" placeholder="Masukkan kode siswa JKN">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="email">Nama Siswa:</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="siswanama" name="siswanama" placeholder="Masukkan Nama Siswa">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="email">Tempat / Tgl Lahir:</label>
                <div class="col-sm-5">
                <input type="text" class="form-control" id="siswatmplahir" name="siswatmplahir" placeholder="Masukkan Tempat Lahir">
                </div>
                <div class="col-sm-5">
                <input type="text" class="form-control" id="siswatgllahir" name="siswatgllahir" placeholder="Masukkan Tanggal Lahir">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="email">Jenis Kelamin:</label>
                <div class="col-sm-10">
                <select name="siswajekel" id="siswajekel" class="form-control">
                    <option value="">Pilih Jekel</option>
                    <option value="Laki-laki">Laki-Laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="email">&nbsp;</label>
                <div class="col-sm-10">
                <input type="checkbox" id="siswastatus" name="siswastatus" value="1">Aktif
                </div>
            </div>
        </form> 
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-primary" id="btnsimpan" onclick="simpan()"><span class="fa fa-save" id="iconsimpan"></span> Simpan</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>