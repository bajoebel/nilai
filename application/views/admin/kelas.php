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
                                    <input type="text" name="q" id="q" class="form-control pull-right" onkeydown="getkelas(1)" placeholder="Search">
                                    <span class="input-group-addon">
                                        <span class="fa fa-search"></span>
                                    </span>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-1">
                            <div class="input-group">
                                <select class="form-control" name="limit" id="limit" onchange="getkelas(1)">
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
                                        <th>Kelas</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Semester Nama</th>
                                        <th>Status</th>
                                        <th style="width: 450px; text-align:right;">#</th>
                                    </tr>
                                </thead>
                                <tbody id="datakelas"></tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6" id="pagination"></td>
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
                <h4 class="modal-title">Tambah kelas</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="form" action="#">
                <input type="hidden" class="form-control" id="kelasid" name="kelasid" placeholder="">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="email">Kelas:</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="kelasnama" name="kelasnama" placeholder="Masukkan kelas">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="email">Tahun Ajaran:</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="kelasta" name="kelasta" placeholder="Masukkan Tahun Ajaran">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="email">Semester:</label>
                        <div class="col-sm-10">
                        <select name="kelassemid" id="kelassemid" class="form-control">
                            <option value="">Pilih Semester</option>
                            <?php 
                            foreach ($sem as $s ) {
                                ?>
                                <option value="<?= $s->semid ?>"><?= $s->semnama ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="email">&nbsp;</label>
                        <div class="col-sm-10">
                        <input type="checkbox" id="kelasstatus" name="kelasstatus" value="1">Aktif
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

<div id="siswa" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Tambah Siswa</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="formsiswa" action="#">
                    <input type="hidden" id="kskelasid" name="kskelasid" placeholder="">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#home">Data Siswa</a></li>
                        <li><a data-toggle="tab" href="#menu1">List Siswa Kelas <span class="namakelas"></span></a></li>
                    </ul>

                    <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td style="width:50px"><input type="checkbox" name="checkall" id="checkallsiswa" value="1" onclick="checkallSiswa()"></td>
                                        <td>Nama Siswa</td>
                                    </tr>
                                </thead>
                                <tbody id="datasiswa">
                                </tbody>
                            </table>
                        </div>
                        <div id="menu1" class="tab-pane fade">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td>Nis</td>
                                        <td>Nama Siswa</td>
                                        <td>#</td>
                                    </tr>
                                </thead>
                                <tbody id="datasiswapilih">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnsimpansiswa" onclick="simpanSiswa()"><span class="fa fa-save" id="iconsimpansiswa"></span> Simpan</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="mapel" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Tambah Mata Pelajaran</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="formmapel" action="#">
                    <input type="hidden" id="kmkelasid" name="kmkelasid" placeholder="">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#mp1">Data Mata Pelajaran</a></li>
                        <li><a data-toggle="tab" href="#mp2">List Mata pelajaran Kelas <span class="namakelas"></span></a></li>
                    </ul>

                    <div class="tab-content">
                        <div id="mp1" class="tab-pane fade in active">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td style="width:50px"><input type="checkbox" name="checkall" id="checkallmapel" value="1" onclick="checkallMapel()"></td>
                                        <td>Nama Mapel</td>
                                    </tr>
                                </thead>
                                <tbody id="datamapel">
                                </tbody>
                            </table>
                        </div>
                        <div id="mp2" class="tab-pane fade">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td>Nama Mapel</td>
                                        <td>#</td>
                                    </tr>
                                </thead>
                                <tbody id="datamapelpilih">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnsimpanmapel" onclick="simpanMapel()"><span class="fa fa-save" id="iconsimpanmapel"></span> Simpan</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>